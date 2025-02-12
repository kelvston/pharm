<?php
date_default_timezone_set('Africa/Dar_es_Salaam');
define('SPCODE', 'SP167');
define('SP_NUMBER', '167');
define('SPSYSID', 'WCF001');
define('SERVER', 'http://154.118.230.18/');
#define('SERVER', 'http://10.1.1.18:80/');
define('POST_BILL_PATH', 'api/bill/qrequest');
define('POST_SIGNED_BILL_PATH', 'api/bill/sigqrequest');
define('RECONCILE_PATH', 'api/reconciliations/sp_qrequest');
define('RABBIT_HOST', '172.16.30.16');
define('RABBIT_PORT', 5672);
define('RABBIT_USER', 'Admin');
define('RABBIT_PASS', 'qaz123.wcf');
define('GEPG_STS_SUCCESS', 7101);
# Number of retries, in case of failure
define('RETRY_COUNT', 4); //70
# Retry Interval in Milli-Seconds
define('RETRY_INTERVAL', 15000); //300000

define('MAC_SERVER', 'http://172.16.30.17:83/');
define('MAC_BILL_PATH', 'control_number');
define('MAC_RECEIPT_PATH', 'return_receipt');
define('MAC_RECON_PATH', 'return_reconciliation');

/*Certificates*/
// define('CERT_PASSWORD', 'passpass');
// define('DATA_TAG', 'gepgBillSubReqAck');
// define('SIGN_TAG', 'gepgSignature');
// define('PUBLIC_CERT_PASSWORD','passpass');
