<?php
// cron script
// /full/path/to/cakeshell UpdateReceiptShell -cli /usr/bin -console /admin/api/lib/Cake/Console -app /full/path/to/app

class UpdateReceiptShell extends AppShell {
    public $uses = array('IapReceipt');

    public function main() {
        $result = $this->IapReceipt->checkAllReceipts();
        $this->out($result);
    }
}