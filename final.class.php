<?php 
class final_rest
{



/**
 * @api  /api/v1/setTemp/
 * @apiName setTemp
 * @apiDescription Add remote temperature measurement
 *
 * @apiParam {string} location
 * @apiParam {String} sensor
 * @apiParam {double} value
 *
 * @apiSuccess {Integer} status
 * @apiSuccess {string} message
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *              "status":0,
 *              "message": ""
 *     }
 *
 * @apiError Invalid data types
 *
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 200 OK
 *     {
 *              "status":1,
 *              "message":"Error Message"
 *     }
 *
 */
	public static function setTemp ($location, $sensor, $value)

	{
		if (!is_numeric($value)) {
			$retData["status"]=1;
			$retData["message"]="'$value' is not numeric";
		}
		else {
			try {
				EXEC_SQL("insert into temperature (location, sensor, value, date) values (?,?,?,CURRENT_TIMESTAMP)",$location, $sensor, $value);
				$retData["status"]=0;
				$retData["message"]="insert of '$value' for location: '$location' and sensor '$sensor' accepted";
			}
			catch  (Exception $e) {
				$retData["status"]=1;
				$retData["message"]=$e->getMessage();
			}
		}

		return json_encode ($retData);
	}

        public static function setStock ($stockTicker, $queryType, $jsonData)

        {
                if ($queryType != ("detail" || "news")) {
                        $retData["status"]=1;
                        $retData["message"]="'$queryType' is not detail or news";
                }
                else {
                        try {
                                EXEC_SQL("insert into stock (dateTime, stockTicker, queryType, jsonData) values (CURRENT_TIMESTAMP,?,?,?)",$stockTicker, $queryType, $jsonData);
                                $retData["status"]=0;
                                $retData["message"]="insert of '$queryType' for stockTicker: '$stockTicker' and jsonData '$jsonData' accepted";
                        }
                        catch  (Exception $e) {
                                $retData["status"]=1;
                                $retData["message"]=$e->getMessage();
                        }
                }

                return json_encode ($retData);
        }

        public static function setStockNews ($stockTicker, $queryType)

        {
                if ($queryType != ("detail" || "news")) {
                        $retData["status"]=1;
                        $retData["message"]="'$queryType' is not detail or news";
                }
                else {
                        try {
                                $jsonData = file_get_contents('php://input');
                                EXEC_SQL("insert into stock (dateTime, stockTicker, queryType, jsonData) values (CURRENT_TIMESTAMP,?,?,?)",$stockTicker, $queryType, $jsonData);
                                $retData["status"]=0;
                                $retData["message"]="insert of '$queryType' for stockTicker: '$stockTicker' and jsonData '$jsonData' accepted";
                        }
                        catch  (Exception $e) {
                                $retData["status"]=1;
                                $retData["message"]=$e->getMessage();
                        }
                }

                return json_encode ($retData);
        }

        public static function getLookup($date, $linemax) {
                try {
                        $retData["result"] = GET_SQL("select * from stock where dateTime like ? limit ?", $date."%", $linemax);
                        $retData["status"] = 0;
                        $retData["message"] = GET_SQL("select count(*) from stock where dateTime like ? limit ?", $date."%", $linemax);;
                } catch (Exception $e) {
                        $retData['status'] = 1;
                        $retData['message'] = $e->getMessage();
                }

                return json_encode($retData);
        }

	public static function getStock ($date)

        {
                        try {
                                $retData["result"] = GET_SQL("select * from stock where dateTime like ? order by dateTime", $date . "%");
                                $retData["status"]=0;
                                $retData["message"]="Stock from '$date' was received successfully";
                        }
                        catch  (Exception $e) {
                                $retData["status"]=1;
                                $retData["message"]=$e->getMessage();
                        }

                return json_encode ($retData);
        }


}

