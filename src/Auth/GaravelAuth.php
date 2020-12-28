<?php

namespace Garavel\Auth;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

/**
 * Active Directory Authentication
 *
 * @author AYDIN.MURAT
 */
class GaravelAuth {

    /** API domain */
    private static $api_domain;

    /** API user */
    private static $api_user;

    /** API password */
    private static $api_pass;

    /** API ye client server üzerinden login olunacak url */
    private static $loginUrl;

    /** API active directory user ının sorgulanacağı url */
    private static $authenticateUrl;

    /** Clientın API üzerinde aldığı token */
    private $apiToken = null;

    public function __construct()
    {

        /**
         * curl extension yüklü mü?
         */
        if (!in_array('curl', get_loaded_extensions()))
        {
            throw new \Exception("curl extension mevcut değil!");
        }

        self::$api_domain = settings('tmdauth_api_domain');
        self::$api_user = settings('tmdauth_api_key');
        self::$api_pass = settings('tmdauth_api_pass');

        self::$loginUrl = self::$api_domain . "/api/login";
        self::$authenticateUrl = self::$api_domain . "/api/checkAdUser";
    }

    /**
     * Authentication servise login olur
     *
     * @return boolean
     */
    public function loginApi()
    {

        try
        {
            $postData = [
                'api_key'  => self::$api_user,
                'password' => self::$api_pass
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::$loginUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            if (self::isTest())
            {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
            ]);

            $result = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($statusCode == 200)
            {

                $data = json_decode($result, true);
                if ($data['result'] == "success")
                {

                    $apiToken = $data['token'];

                    $this->apiToken = $apiToken;

                    DB::table('settings')
                        ->where('key', 'tmdauth_token')
                        ->update(['value' => $apiToken]);

                    return true;
                }
            }
        } catch (\Exception $e)
        {
            echo $e->getMessage();
        }

        return false;
    }

    /**
     * Active Directory User login kontrolü
     *
     * @param type $user
     * @param type $pass
     * @param type $returnResponse default: false
     *
     * @return type ($returnResponse=false -> boolean) / ($returnResponse=true -> response)
     */
    public function authenticate($user, $pass, $returnResponse = false)
    {

        /** Api servisi için Tablo'deki api tokenı al. Null ise yeniden login olur ve token döner
         * DB tarafında null olmasa dahi mevcut token expired olmuş olabilir.
         * Bunu durumu anlamanın yolu, ilk requestin responsunda "Unauthenticated." mesajının alınıp alınmaması.
         */
        $apiToken = $this->getApiToken();

        $requestAuthentication = $this->requestAuthenticationService($apiToken, $user, $pass);

        $response = json_decode($requestAuthentication['response'], true);
        $statusCode = $requestAuthentication['statusCode'];

        /** Servis Unauthenticated response mesajı alıyorsa, api_token expired olmuş demektir.
         * Yeniden login ol ve yeniden request et.
         */
        if ($response['message'] && $response['message'] == "Unauthenticated.")
        {
            $this->loginApi();
            $apiToken = $this->apiToken;

            $reRequestAuthentication = $this->requestAuthenticationService($apiToken, $user, $pass);
            $response = json_decode($reRequestAuthentication['response'], true);
            $statusCode = $reRequestAuthentication['statusCode'];
        }

        if ($statusCode == 200)
        {
            if ($response['result'] == "success")
            {
                return true;
            } else
            {
                return false;
            }
        }

        return false;
    }

    /**
     * Authentication Servisine request eder
     *
     * @param type $apiToken
     * @param type $user
     * @param type $pass
     *
     * @return array
     */
    private function requestAuthenticationService($apiToken, $user, $pass)
    {
        try
        {
            /** Auth Tmd servisine Active Directory user bilgilerini post et */
            $postData = [
                'api_token' => $apiToken,
                'user'      => $user,
                'password'  => $pass
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::$authenticateUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds
            if (self::isTest())
            {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
            ]);
            $response = curl_exec($ch);

            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (curl_error($ch))
            {
                return ['result' => 'success', 'response' => $response, 'statusCode' => $statusCode];
            }
            curl_close($ch);

            return ['result' => 'success', 'response' => $response, 'statusCode' => $statusCode];
        } catch (\Exception $e)
        {

            return ['result' => 'fail', 'message' => $e->getMessage()];
        }
    }

    /**
     * Tabloda oluşturulmuş Api Token ı getir
     * Yoksa oluşturur
     *
     * @return string
     */
    public function getApiToken()
    {
        $getApiToken = DB::table('settings')
            ->where('key', 'tmdauth_token')
            ->first();

        if ($getApiToken && !is_null($getApiToken->value) && $getApiToken->value != '')
        {
            $this->apiToken = $getApiToken->value;
        } else
        {
            $this->loginApi();
            $apiToken = $this->apiToken;
        }

        return $this->apiToken;
    }

    public static function isTest()
    {
        if (App::environment() == "local")
        {
            return true;
        }

        return false;
    }

}
