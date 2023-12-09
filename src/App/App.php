<?php
declare(strict_types=1);

namespace Vasilaki\Php2023\App;

use Vasilaki\Php2023\Request\Request;
use Vasilaki\Php2023\Response\Response;
use Vasilaki\Php2023\Validatos\EmailDNSValidator;

class App
{
    /**
     * @var string
     */
    public function __construct()
    {
    }


    public function run()
    {
        $request = new Request();
        $code = 400;
        if($request->email){
            $emailValidator = new EmailDNSValidator($request->email);
            if($emailValidator->validate()){
                $code = 200;
            }
        }
        $response = new Response($code);
        $response->setResponseCode();
    }
}