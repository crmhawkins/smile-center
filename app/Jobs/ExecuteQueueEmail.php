<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\MailNewsletter;
use Illuminate\Support\Facades\Mail;
use App\Models\Newsletters\Newsletter;
use Illuminate\Support\Facades\Log;
use App\Models\Notes\Notes;
use Hawkins\Models\AdminUser;
use App\Models\Alerts\Alert;
use App\Models\Paciente;
use App\Models\Contacts\Contact;
use App\Models\Services\ServicesCategories;
use App\Models\Budgets\Budget;
use App\Models\Budgets\BudgetConcepts;
use App\Models\Newsletters\NewsletterManual;
use App\Models\Newsletters\NewsletterFavourites;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use DataTables;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Logs;

class ExecuteQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $obj;
    public $timeout = 75600; // 21 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($obj)
    {
        $this->obj = $obj;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        if($this->obj->type == "lead"){
            $this->newsletterToLeads($this->obj);
        }else{
            $this->newsletterToClients($this->obj);
        }

    }

    public function newsletterToClients($request){

        $newsletterObject = new \stdClass();
        $images_path = $request->images_path;
        $urls_array = array();
        if($request->clients){
            if($request->clients[0] == "all"){
                $clients = Paciente::where('estado_id', 3)->where('newsletter',1)->whereNotNull('email')->pluck('id')->toArray();
                $clients_serialize = 0;
                $request->clients = $clients;
            }else{
                $clients_serialize = base64_encode(serialize($request->clients));

            }
        }

        if($request->date){
            $dateTimeString = $request->date." ".$request->hour;
            // dd($dateTimeString);
            $date = Carbon::createFromFormat('Y-m-d H:i', $dateTimeString, 'Europe/Madrid');
        }

        foreach ($request->urls as $url) {
            $urls_array[] = $url;
        }

        $data = [
            "pacientes_array_id" => $clients_serialize,
            "date_sent" => $date->format('Y-m-d H:i'),
            "first_title_newsletter" => $request->title,
            "banner_description" => $request->img_description,
            "second_title_newsletter" => $request->title_second,
            "images_promo" => json_encode($images_path),
            "urls" => json_encode($urls_array),
         ];
        $newsletter = NewsletterManual::create($data);
        $newsletter->images_promo = json_decode($newsletter->images_promo);
        $newsletter->urls = json_decode($newsletter->urls);

        $data = [
            'action' => 'Crear Newsletters',
            'descripcion' => 'Creacion de Newsletters con id: '. $newsletter->id,
            'status' => ''
        ];


        $newsletterObject->id_foreign = $newsletter->id;
        $newsletterObject->first_title_newsletter = $newsletter->first_title_newsletter;
        $newsletterObject->banner_description = $newsletter->banner_description;
        $newsletterObject->description = $newsletter->second_title_newsletter;

        foreach ($newsletter->images_promo as $promo) {
            $newsletterObject->promo[] = $promo;
        }

        foreach ($newsletter->urls as $url) {
            $newsletterObject->urls[] = $url;
        }

        foreach ($request->clients as $client) {
            $cliente = Paciente::find($client);
            $newsletterObject->paciente_id = $cliente->id;
            if($cliente->email){
                $validator = $this->validateEmail($cliente->email);

                if($validator->passes()){
                    $newsletterObject->to = $cliente->email;
                    $newsletterObject->delay = $date;
                    $added = $this->jobAdd($newsletterObject);
                }
            }
        }
    }

    public function newsletterToLeads($request){
        $contador = 0;
        $arrayClients = array();
        $newsletterObject = new \stdClass();
        $images_path = $request->images_path;
        $urls_array = array();

        if($request->type == "lead"){
                $clients =  Paciente::where('estado_id', 1)->where('newsletter',1)->whereNotNull('email')->pluck('id')->toArray();
            $clients_serialize = 1;
        }

        if($request->date){
            $dateTimeString = $request->date." ".$request->hour;
            // dd($dateTimeString);
            $date = Carbon::createFromFormat('Y-m-d H:i', $dateTimeString, 'Europe/Madrid');
        }

        foreach ($request->file() as $file) {
            $filename = str::random(10).".".$file->getClientOriginalExtension();
            Storage::disk('images')->put($filename, File::get($file));
            $images_path[] = $filename;
        }

        foreach ($request->urls as $url) {
            $urls_array[] = $url;
        }

        $data = [
            "pacientes_array_id" => $clients_serialize,
            "date_sent" => $date->format('Y-m-d H:i'),
            "first_title_newsletter" => $request->title,
            "banner_description" => $request->img_description,
            "second_title_newsletter" => $request->title_second,
            "images_promo" => json_encode($images_path),
            "urls" => json_encode($urls_array),
         ];

        $newsletter = NewsletterManual::create($data);
        $newsletter->images_promo = json_decode($newsletter->images_promo);
        $newsletter->urls = json_decode($newsletter->urls);

        $data = [
            'action' => 'Crear Newsletters',
            'descripcion' => 'Creacion de Newsletters con id: '. $newsletter->id,
            'status' => ''
        ];


        $newsletterObject->id_foreign = $newsletter->id;
        $newsletterObject->first_title_newsletter = $newsletter->first_title_newsletter;
        $newsletterObject->banner_description = $newsletter->banner_description;
        $newsletterObject->description = $newsletter->second_title_newsletter;

        foreach ($newsletter->images_promo as $promo) {
            $newsletterObject->promo[] = $promo;
        }

        foreach ($newsletter->urls as $url) {
            $newsletterObject->urls[] = $url;
        }

        foreach ($clients as $client){
            if($contador == 11){
                $date = $date->addMinutes(3);
                $contador = 0;
            }

            $cliente =  Paciente::find($client);

            if($cliente){
                $validator = $this->validateEmail($cliente->email);
                if($validator->passes()){
                    $newsletterObject->paciente_id = $cliente->id;
                    $newsletterObject->to = $cliente->email;
                    $newsletterObject->delay = $date;

                    $isSent = $this->jobAdd($newsletterObject);
                    if($isSent){
                        $contador += 1;
                    }
                }
            }
        }
    }

    protected function validateEmail($email){
        $validator = Validator::make(['email' => $email],
        [
            'email' => 'required|email'
        ]);

        return $validator;
    }

    private function jobAdd($newsletterObject){

        if($newsletterObject->to){

            $data = [
                'paciente_id' => $newsletterObject->paciente_id,
                'newsletter_id' => $newsletterObject->id_foreign,
                'campaign' => 'newsletter_manual',
                'email' => $newsletterObject->to,
                'date_sent' => $newsletterObject->delay->format('Y-m-d H:i:s'),
            ];

            $newsletter = Newsletter::create($data);

            $newsletterObject->id_newsletter = $newsletter->id;

            $client = Paciente::find($newsletterObject->paciente_id);
            $client->last_newsletter = $newsletterObject->delay;
            $client->save();

            $job = (new \App\Jobs\SendBulkQueueEmail($newsletterObject))->delay($newsletterObject->delay->addSeconds(2));
            dispatch($job)->onQueue('newsletter_manual');
            $isSent = true;

            return $isSent;


        }else{
            Log::info("EL EMAIL ".$newsletterObject->to." SE HA DADO DE BAJA EN LAS NEWSLETTERS");
        }
    }
}

?>
