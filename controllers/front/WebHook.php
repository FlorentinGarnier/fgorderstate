<?php

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

require_once(_PS_MODULE_DIR_ . 'attools/classes/UrbantzTasksModel.php');

class FgorderstateWebHookModuleFrontController extends ModuleFrontController
{

    /**
     * Urbantz Webhook entrypoint
     * @inheritDoc
     */
    public function postProcess()
    {
        try {
            if (!Tools::getIsset('order_id')) {
                throw new Exception('order_id is missing');
            }
            if (!Tools::getIsset('token')) {
                throw new Exception('token is missing');
            }
            if (!Tools::getIsset('method')) {
                throw new Exception('method is missing');
            }

            if (Tools::getValue('token') !== 'abracadabra') {
                throw new Exception('wrong token');
            }

            if ('task_status_change' === Tools::getValue('method')) {

                $Order = new Order(Tools::getValue('order_id'));
                $Order->setCurrentState(5);

            }
        } catch (Exception $exception) {
            echo $exception->getMessage();
            header('HTTP/1.1 400 ' . $exception->getMessage());
            exit(0);
        }

        echo 'OK';
        exit(0);

    }
}
