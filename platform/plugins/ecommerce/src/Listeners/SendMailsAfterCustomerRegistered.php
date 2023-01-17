<?php

namespace Botble\Ecommerce\Listeners;

use Botble\Ecommerce\Models\Customer;
use EcommerceHelper;
use EmailHandler;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Throwable;

class SendMailsAfterCustomerRegistered
{
    /**
     * Handle the event.
     *
     * @param Registered $event
     * @return void
     * @throws FileNotFoundException
     * @throws Throwable
     */
    public function handle(Registered $event)
    {
        $customer = $event->user;

         $url=$_SERVER['REQUEST_URI'];
        
         $url=explode('/',$url);
        //  print_r($url);
        // exit;
        if (get_class($customer) == Customer::class) {
            $lng = "it";
            if(strlen($url[1]) == 2){
                $lng = $url[1];
            }
            EmailHandler::setModule(ECOMMERCE_MODULE_SCREEN_NAME)
                ->setVariableValues([
                    'customer_name' => $customer->name,
                ])
                
                ->sendUsingTemplate($lng.'_welcome', $customer->email);

            if (EcommerceHelper::isEnableEmailVerification()) {
                // Notify the user
                $customer->sendEmailVerificationNotification();
            }
        }
    }
}
