<?php

namespace App\AjaxForm;

use Illuminate\Http\JsonResponse;

class Response
{
    /**
     * Mensaje
     *
     * @var array
     */
    protected $message;

    /**
     * Errores en la validación
     *
     * @var array
     */
    protected $validation;

    /**
     * Redirección
     *
     * @var array
     */
    protected $redirection;

    /**
     * Datos personalizados
     *
     * @var mixed
     */
    protected $customData;

    /**
     * Añadir mensaje a la respuesta
     *
     * @param string $type (success, error, warning, info, question)
     * @param string|null $title
     * @param string|null $text
     *
     * @return AjaxFormResponse
     */
    public function message(string $type, string $title = null, string $text = null)
    {
        $this->message = [
            'type' => $type,
            'title' => $title,
            'text' => $text,
        ];

        return $this;
    }

    /**
     * Añade los errores de validación a la respuesta
     *
     * @param array $errors
     *
     * @return AjaxFormResponse
     */
    public function validation(array $errors)
    {
        $this->validation = $errors;

        return $this;
    }

    /**
     * Añadir la rediracción a la respuesta
     *
     * @param string $url
     * @param int $delay
     *
     * @return AjaxFormResponse
     */
    public function redirection(string $url, int $delay)
    {
        $this->redirection = [
            'url' => $url,
            'delay' => $delay,
        ];

        return $this;
    }

    /**
     * Añadir datos personalizados a la respuesta
     *
     * @param mixed $data
     *
     * @return AjaxFormResponse
     */
    public function custom($data)
    {
        $this->customData = $data;

        return $this;
    }

    /**
     * Generar un array con los datos de la respuesta
     *
     * @return array
     */
    public function toArray()
    {
        $result = [];

        if ($this->message) {
            $result['message'] = $this->message;
        }
        if ($this->validation) {
            $result['validation'] = $this->validation;
        }
        if ($this->redirection) {
            $result['redirection'] = $this->redirection;
        }
        if ($this->customData) {
            $result['custom'] = $this->customData;
        }

        return $result;
    }

    /**
     * Genera una respuesta JSON (JsonResponse)
     *
     * @return JsonResponse
     */
    public function jsonResponse($status = 200, $headers = [], $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
    {
        return new JsonResponse($this->toArray(), $status, $headers, $options);
    }
}
