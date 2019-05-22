<?php
/**
 * Invoice Ninja (https://invoiceninja.com)
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2019. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

namespace App\Http\Middleware;

use App\Libraries\MultiDB;
use App\Models\CompanyToken;
use Closure;

class SetDb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next)
    {

        $error['error'] = ['message' => 'Database could not be set'];


        if( $request->header('X-API-TOKEN') && (CompanyToken::whereRaw("BINARY `token`= ?",[$request->header('X-API-TOKEN')])->first()) && config('ninja.db.multi_db_enabled')) 
        {

            if(! MultiDB::findAndSetDb($request->header('X-API-TOKEN')))
            {

            return response()->json(json_encode($error, JSON_PRETTY_PRINT) ,403);

            }
        
        }
        else {


            return response()->json(json_encode($error, JSON_PRETTY_PRINT) ,403);
        }

        return $next($request);
    }


}