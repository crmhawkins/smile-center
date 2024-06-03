<?php

namespace App\Helpers;

use App\AjaxForm\Response as AjaxFormResponse;

class AjaxForm
{
    /**
     * Crea la respuesta con un mensaje
     *
     * @param  string  $type
     * @param  string|null  $title
     * @param  string|null  $text
     *
     * @return  AjaxFormResponse
     */
    public static function message(string $type, string $title = null, string $text = null)
    {
        $response = new AjaxFormResponse();
        return $response->message($type, $title, $text);
    }

    /**
     * Crea la respuesta con un mensaje de información
     *
     * @param  string  $text
     * @param  string|null  $title
     *
     * @return  AjaxFormResponse
     */
    public static function infoMessage(string $text, string $title = null)
    {
        return self::message('info', $title ?: trans('hawkins::common.title_info'), $text);
    }

    /**
     * Crea la respuesta con un mensaje de éxito
     *
     * @param  string  $text
     * @param  string|null  $title
     *
     * @return  AjaxFormResponse
     */
    public static function successMessage(string $text, string $title = null)
    {
        return self::message('success', $title ?: trans('hawkins::common.title_success'), $text);
    }

    /**
     * Crea la respuesta con un mensaje de advertencia
     *
     * @param  string  $text
     * @param  string|null  $title
     *
     * @return  AjaxFormResponse
     */
    public static function warningMessage(string $text, string $title = null)
    {
        return self::message('warning', $title ?: trans('hawkins::common.title_warning'), $text);
    }

    /**
     * Crea la respuesta con un mensaje de error
     *
     * @param  string  $text
     * @param  string|null  $title
     *
     * @return  AjaxFormResponse
     */
    public static function errorMessage(string $text, string $title = null)
    {
        return self::message('error', $title ?: trans('hawkins::common.title_error'), $text);
    }

    /**
     * Crea la respuesta con los errores de validación
     *
     * @param array $errors
     *
     * @return AjaxFormResponse
     */
    public static function validation($errors)
    {
        $response = new AjaxFormResponse();
        return $response->validation($errors);
    }

    /**
     * Crea una respuesta con redirección
     *
     * @param  string  $url
     * @param  int  $delay
     *
     * @return  AjaxFormResponse
     */
    public static function redirection(string $url, int $delay = 0)
    {
        $response = new AjaxFormResponse();
        return $response->redirection($url, $delay);
    }

    /**
     * Crea la respuesta con datos personalizados
     *
     * @param  mixed  $data
     *
     * @return  AjaxFormResponse
     */
    public static function custom($data)
    {

        $response = new AjaxFormResponse();

        return $response->custom($data);
    }
}
