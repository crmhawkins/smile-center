<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\AjaxForm;
use App\Models\Paciente;
use App\Models\Contacts\Contact;
use App\Models\Budgets\Budget;
use App\Models\Budgets\BudgetConcepts;
use App\Models\Newsletters\Newsletter;
use App\Models\Newsletters\NewsletterManual;
use App\Models\Newsletters\NewsletterFavourites;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Validator;

class NewslettersController extends Controller{


    public function index(){
        $newsletters = NewsletterManual::orderBy('created_at', 'desc')->get();

        foreach ($newsletters as $newsletter) {
            $arrayClients = array();

            $newsletter->pacientes_array_id = unserialize(base64_decode($newsletter->pacientes_array_id));

            if($newsletter->pacientes_array_id){
            	foreach ($newsletter->pacientes_array_id as $client) {
                    $arrayClients[] = Paciente::find($client);
                }
                $newsletter->clients_id = $arrayClients;
            }else{
            	$newsletter->clients_id = "all";
            }
        }

        return view('newsletters.index', compact('newsletters'));
    }

    protected function validateEmail($email){
        $validator = Validator::make(['email' => $email],
        [
            'email' => 'required|email'
        ]);

        return $validator;
    }

    public function create(){
        $clients = Paciente::where('estado_id', 3)->where('newsletter',1)->whereNotNull('email')->get();
return view('newsletters.create', compact('clients'));
    }

    public function store(Request $request){
        $images_path = array();
        $now = Carbon::now();
        $request->validate([
            'title' => 'required',
        ]);

        foreach ($request->file() as $file) {
            $filename = Str::random(10).".".$file->getClientOriginalExtension();
            Storage::disk('images')->put($filename, File::get($file));
            $images_path[] = $filename;
        }

        $request = $request->except(['banner', 'promo1', 'promo2', 'promo3', 'promo4', 'promo5', 'promo6']);

        $request['images_path'] = $images_path;

        $request = new Request($request);


        $job = (new \App\Jobs\ExecuteQueueEmail($request))->delay($now->addSeconds(15));
        dispatch($job);


        // Respuesta
        return AjaxForm::custom([
            'message' => 'Newsletter creada.',
            'entryUrl' => route('marketing.newsletters.index'),
        ])->jsonResponse();
    }


    public function edit(NewsletterManual $newsletter){

        $clients = Paciente::where('estado_id', 3)->where('newsletter',1)->whereNotNull('email')->get();

        if($newsletter->pacientes_array_id == "0" || $newsletter->pacientes_array_id == "1"){
            $newsletter->pacientes_array_id = "all";
        }else{
            $newsletter->pacientes_array_id = unserialize(base64_decode($newsletter->pacientes_array_id));
        }
        $newsletter->images_promo = json_decode($newsletter->images_promo);
        $newsletter->urls = json_decode($newsletter->urls);

        return view('newsletters.edit', compact('newsletter', 'clients'));
    }


    public function update(Request $request, NewsletterManual $newsletter){
        $urls_array = array();
        $images_path = array();
        $newsletter->images_promo = json_decode($newsletter->images_promo);

        $request->validate([
            'first_title_newsletter' => 'required',
        ]);

        $clients_serialize = base64_encode(serialize($request->clients));

        $dateTimeString = $request->date." ".$request->hour;
        $date = Carbon::createFromFormat('d/m/Y H:i', $dateTimeString, 'Europe/Madrid');

        $data = $request->all();

        if(!isset($data['banner'])){
            $data['banner'] = $newsletter->images_promo[0];
            $images_path[] = $newsletter->images_promo[0];
        }else{
            Storage::disk('images')->delete($newsletter->images_promo[0]);
            $file = $request->file('banner');

            $filename = Str::random(10).".".$file->getClientOriginalExtension();
            Storage::disk('images')->put($filename, File::get($file));
            $images_path[] = $filename;
        }

        for($i = 1; $i <=6; $i++){
            if(!isset($data['promo'.$i])){
                $data['promo'.$i] = $newsletter->images_promo[$i];
                $images_path[] = $newsletter->images_promo[$i];
            }else{
                Storage::disk('images')->delete($newsletter->images_promo[$i]);
                $file = $request->file('promo'.$i);

                $filename = Str::random(10).".".$file->getClientOriginalExtension();
                Storage::disk('images')->put($filename, File::get($file));
                $images_path[] = $filename;
            }
        }

        foreach ($request->urls as $url) {
            $urls_array[] = $url;
        }

        $data = [
            "pacientes_array_id" => $clients_serialize,
            "category" => $request->category,
            "date_sent" => $date->format('Y-m-d H:i'),
            "first_title_newsletter" => $request->first_title_newsletter,
            "banner_description" => $request->banner_description,
            "second_title_newsletter" => $request->second_title_newsletter,
            "images_promo" => json_encode($images_path),
            "urls" => json_encode($urls_array),
        ];

        $newsletter->fill($data);
        $newsletter->save();


        return AjaxForm::custom([
            'message' => 'Newsletter actualizada correctamente',
            'entryUrl' => route('marketing.newsletters.edit', $newsletter->id),
        ])->jsonResponse();

    }

    public function destroy(NewsletterManual $newsletter){
        $newsletter->images_promo = json_decode($newsletter->images_promo);

        foreach ($newsletter->images_promo as $image){
            Storage::disk('images')->delete($image);
        }

        $newsletter->delete();

        NewsletterFavourites::where('newsletter_id', $newsletter->id)->delete();

        return AjaxForm::custom([
            'message' => 'Newsletter borrada correctamente',
            'entryUrl' => route('marketing.newsletters.index'),
        ])->jsonResponse();

    }

    public function send(NewsletterManual $newsletter, Request $request){
        $newsletterObject = new \stdClass();

        if($newsletter->pacientes_array_id == "0"){
             $clients = Paciente::where('is_client', 1)->whereNotNull('email')->pluck('id')->toArray();
             $newsletter->pacientes_array_id = $clients;
        }else{
            $newsletter->pacientes_array_id = unserialize(base64_decode($newsletter->pacientes_array_id));
        }

        $newsletter->images_promo = json_decode($newsletter->images_promo);
        $newsletter->urls = json_decode($newsletter->urls);

        if($request->date){
            $dateTimeString = $request->date." ".$request->hour;
            $date = Carbon::createFromFormat('d/m/Y H:i', $dateTimeString, 'Europe/Madrid');
        }

        $newsletterObject->id_foreign = $newsletter->id;
        $newsletterObject->category = $newsletter->category;
        $newsletterObject->first_title_newsletter = $newsletter->first_title_newsletter;
        $newsletterObject->banner_description = $newsletter->banner_description;
        $newsletterObject->description = $newsletter->second_title_newsletter;

        foreach ($newsletter->images_promo as $promo) {
            $newsletterObject->promo[] = $promo;
        }

        foreach ($newsletter->urls as $url) {
            $newsletterObject->urls[] = $url;
        }

        foreach ($newsletter->pacientes_array_id as $client) {
            $cliente = Paciente::find($client);
            $newsletterObject->client_id = $cliente->id;
            if(!$cliente->contacts->isEmpty()){
                foreach ($cliente->contacts as $contact) {
                    $newsletterObject->to = $contact->email;
                    $newsletterObject->delay = $date;
                    $this->addMailToJob($newsletterObject);
                }
            }else{
                $newsletterObject->to = $cliente->email;
                $newsletterObject->delay = $date;
                $this->addMailToJob($newsletterObject);
            }
        }

        // Respuesta
        return AjaxForm::custom([
            'message' => 'Newsletter enviada.',
            'entryUrl' => route('marketing.newsletters.edit', $newsletter->id),
        ])->jsonResponse();

    }

    public function statistics(){

    	$newsletters = NewsletterManual::orderBy('created_at', 'desc')->get();

    	$newsletters_actives = Newsletter::All();

        return view('newsletters.statistics', compact('newsletters_actives', 'newsletters'));
    }

    public function getNewslettersByDataTables(){

    	$newsletters_actives = Newsletter::orderby('id', 'DESC');

        return Datatables::of($newsletters_actives)
        	 ->addColumn('cliente', function ($newsletter) {
                if($newsletter->client){
                    return $newsletter->client->name;
                }
                else{
                    return " ";
                }
            })
        	->addColumn('enviado', function ($newsletter) {
                if($newsletter->sent == 1){
                    return htmlspecialchars_decode('<div><i class="fas fa-check" style="color: green;"></i></div>');
                }
                else{
                    return htmlspecialchars_decode('<i class="fas fa-times" style="color: red;"></i>');
                }
            })
            ->addColumn('abierto', function ($newsletter) {
                if($newsletter->open == 1){
                    return htmlspecialchars_decode('<div><i class="fas fa-check" style="color: green;"></i></div>');
                }
                else{
                    return htmlspecialchars_decode('<i class="fas fa-times" style="color: red;"></i>');
                }
            })
            ->escapeColumns(null)
        	->make();
    }

    public function getNewslettersFilterByDataTables(NewsletterManual $newsletter){
        $newsletters_actives = Newsletter::where('newsletter_id', $newsletter->id)->orderby('id', 'DESC');

        return Datatables::of($newsletters_actives)
        	 ->addColumn('cliente', function ($newsletter) {
                if($newsletter->client){
                    return $newsletter->client->name;
                }
                else{
                    return " ";
                }
            })
        	->addColumn('enviado', function ($newsletter) {
                if($newsletter->sent == 1){
                    return htmlspecialchars_decode('<div><i class="fas fa-check" style="color: green;"></i></div>');
                }
                else{
                    return htmlspecialchars_decode('<i class="fas fa-times" style="color: red;"></i>');
                }
            })
            ->addColumn('abierto', function ($newsletter) {
                if($newsletter->open == 1){
                    return htmlspecialchars_decode('<div><i class="fas fa-check" style="color: green;"></i></div>');
                }
                else{
                    return htmlspecialchars_decode('<i class="fas fa-times" style="color: red;"></i>');
                }
            })
            ->escapeColumns(null)
        	->make();
    }

    public function getNewslettersFilterDatesByDataTables(Request $request){

    	$min = Carbon::createFromFormat('d-m-Y', $request->min, 'Europe/Madrid')->startOfDay();
    	$max = Carbon::createFromFormat('d-m-Y', $request->max, 'Europe/Madrid')->startOfDay();

    	$newsletters_actives = Newsletter::where('newsletter_id', $request->id)->whereBetween('date_sent', [$min, $max])->orderby('id', 'DESC');

        return Datatables::of($newsletters_actives)
        	 ->addColumn('cliente', function ($newsletter) {
                if($newsletter->client){
                    return $newsletter->client->name;
                }
                else{
                    return " ";
                }
            })
        	->addColumn('enviado', function ($newsletter) {
                if($newsletter->sent == 1){
                    return htmlspecialchars_decode('<div><i class="fas fa-check" style="color: green;"></i></div>');
                }
                else{
                    return htmlspecialchars_decode('<i class="fas fa-times" style="color: red;"></i>');
                }
            })
            ->addColumn('abierto', function ($newsletter) {
                if($newsletter->open == 1){
                    return htmlspecialchars_decode('<div><i class="fas fa-check" style="color: green;"></i></div>');
                }
                else{
                    return htmlspecialchars_decode('<i class="fas fa-times" style="color: red;"></i>');
                }
            })
            ->escapeColumns(null)
        	->make();
    }

    public function getInfoNewsletter(Request $request){
    	$newsletters = Newsletter::where('newsletter_id', $request->id)->orderby('id', 'DESC')->get();

    	foreach ($newsletters as $newsletter) {
    		$contact = Contact::where('email', $newsletter->email)->get()->first();

            if($contact){
                 if(!$contact->newsletters_sending_accepted){
                   	$newsletter->baja = 1;
                }
            }else{
                $client = Paciente::where('email', $newsletter->email)->get()->first();

                if(!$client->newsletters_sending_accepted){
                    $newsletter->baja = 1;
                }
            }
        }

    	return response()->json($newsletters);
    }

    public function smartNewsletters(){
        $favs = array();
        $newslettersFavs = NewsletterFavourites::where('user_id', Auth::user()->id)->get();

        foreach ($newslettersFavs as $fav) {
            $favs[] = $fav->newsletter;
            $arrayClients = array();
            $fav->newsletter->pacientes_array_id = unserialize(base64_decode($fav->newsletter->pacientes_array_id));
            foreach ($fav->newsletter->pacientes_array_id as $client) {
                $arrayClients[] = Paciente::find($client);
            }

            $fav->newsletter->clients_id = $arrayClients;
        }

        return view('newsletters.smartnewsletters', compact('favs'));
    }

    public function runSmartNewsletters(Request $request){

        $request->validate([
            'newsletter' => 'required',
        ]);

        $newsletter = NewsletterManual::find($request->newsletter);
        $newsletter->images_promo = json_decode($newsletter->images_promo);

        $contador = 0;
        $now = Carbon::now('Europe/Madrid');

        $now->next(Carbon::THURSDAY);
        $now->hour = 12;
        $now->minute = 00;

        $budgets = Budget::where('budget_status_id', 6)->latest('client_id')->orderby('updated_at', 'desc')->get()->unique('client_id');

        foreach ($budgets as $budget) {
            if($contador == 11){
                $now = $now->addMinutes(3);
                $contador = 0;
            }

            $date30initial = Carbon::parse($budget->client->last_newsletter);
            $date30days = $date30initial->addDays(30);

            if($now->greaterThanOrEqualTo($date30days) || $budget->client->last_newsletter==null){

                $isSent = $this->newsletter30Days($budget, $now, $newsletter);
                if($isSent){
                    $contador += 1;
                }
            }
        }

        return AjaxForm::custom([
            'message' => 'Newsletter creada',
            'entryUrl' => route('marketing.newsletters.edit', $newsletter->id),
        ])->jsonResponse();
    }

    protected function newsletter30Days($budget, $now, $newsletter){
        $isSent = false;
        $client = Paciente::find($budget->client->id);

        $concepts = BudgetConcepts::where('budget_id', $budget->id)->whereNotNull('services_category_id')->get()->pluck('services_category_id')->toArray();

        if($concepts){
            $newsletterObject = new \stdClass();
            $newsletterObject->services = $this->getServicesFromArray($concepts);

            if(!$budget->client->contacts->isEmpty()){
                foreach ($budget->client->contacts as $contact) {
                    $newsletterObject->client_id = $budget->client->id;
                    $newsletterObject->to = $contact->email;
                    //$newsletterObject->to = "alejandro@lchawkins.com";
                    $this->addMailToJob($newsletterObject, $now, $newsletter);
                    $client->last_newsletter = $now;
                    $isSent = true;
                    //Log::debug("DELAY COLA 3: ".$now." Cliente Name: ".$budget->client->name." Email: ".$budget->client->email." Contactos: ".$budget->client->contacts);
                    $client->save();
                }
            }else{
                if($budget->client->email){
                    $newsletterObject->client_id = $budget->client->id;
                    $newsletterObject->to = $budget->client->email;
                    //$newsletterObject->to = "alejandro@lchawkins.com";
                    $this->addMailToJob($newsletterObject, $now, $newsletter);
                    $client->last_newsletter = $now;
                    $isSent = true;
                    //Log::debug("DELAY COLA 3: ".$now." Cliente Name: ".$budget->client->name." Email: ".$budget->client->email." Contactos: ".$budget->client->contacts);
                    $client->save();
                }
            }
        }

        return $isSent;
    }

    protected function getServicesFromArray($concepts){
        $services = array(59, 62, 50, 56, 63, 57, 43, 58, 45, 60, 65);

        if(count($concepts) == 1){
            $arrayDif = array_diff($services, $concepts);
            $arrayRand = array_rand($arrayDif, 7);
        }
        else if(count($concepts)==2){
            $arrayDif = array_diff($services, $concepts);
            $arrayRand = array_rand($arrayDif, 7);
        }
        else if(count($concepts)>=3){
            $arrayRand = array_rand($services, 7);
        }

        return $arrayRand;
    }

    public function favourites(){
        $favs = array();
        $newslettersFavs = NewsletterFavourites::where('user_id', Auth::user()->id)->get();

        foreach ($newslettersFavs as $fav) {
            $favs[] = $fav->newsletter;
            $arrayClients = array();
            $fav->newsletter->pacientes_array_id = unserialize(base64_decode($fav->newsletter->pacientes_array_id));
            foreach ($fav->newsletter->pacientes_array_id as $client) {
                $arrayClients[] = Paciente::find($client);
            }

            $fav->newsletter->clients_id = $arrayClients;
        }

        return view('newsletters.favourites', compact('favs'));
    }

    public function addFavourites(NewsletterManual $newsletter){

        $newsletterExist = NewsletterFavourites::where('user_id', Auth::user()->id)->where('newsletter_id', $newsletter->id)->get()->first();

        if(!$newsletterExist){
            $data = [
                'user_id' => Auth::user()->id,
                'newsletter_id' => $newsletter->id
            ];

            $fav = NewsletterFavourites::create($data);

            return AjaxForm::custom([
                'message' => 'Newsletter añadida a favoritos',
                'entryUrl' => route('marketing.newsletters.edit', $newsletter->id),
            ])->jsonResponse();

        }else{

            return AjaxForm::custom([
                'message' => 'Ya tienes está newsletters en favoritos.',
                'entryUrl' => route('marketing.newsletters.edit', $newsletter->id),
            ])->jsonResponse();
        }
    }

}
