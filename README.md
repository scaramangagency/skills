**Authentication**
----
You should send your `Username` and `Password` through a `Basic Auth` header.

**API Endpoints**
----
**get-ducks**
_Return a list of all ducks_

|||
|--|--|
|URL|`/get-ducks`|
|Method|`GET`|
|Successful Response|```{"success":true,"response":[{"id":1,"name":"duck","price":10,"created":{"date":"2021-01-20 15:46:02.000000","timezone_type":3,"timezone":"Europe/London"}},{"id":2,"name":"duck","price":10,"created":{"date":"2021-01-20 15:46:02.000000","timezone_type":3,"timezone":"Europe/London"}}]}```|
|Error Response|**Invalid Credentials** <br>```{"name":"Unauthorized","message":"Your request was made with invalid credentials.","code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"}```|

**get-ducks/1**
_Return a specific duck from supplied ID_

|||
|--|--|
|URL|`/get-ducks/<id>`|
|Method|`GET`|
|Successful Response|```{"success":true,"response":[{"id":9,"name":"duck","price":10,"created":{"date":"2021-01-20 15:46:02.000000","timezone_type":3,"timezone":"Europe/London"}}]}```|
|Error Response|**Invalid Credentials** <br>```{"name":"Unauthorized","message":"Your request was made with invalid credentials.","code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"}```<br>**No Record**<br>```{"name":"Bad Request","message":"A duck does not exist with that id.","code":0,"status":400,"type":"yii\\web\\BadRequestHttpException"}```<br>**Not your duck**<br>```{"name":"Unauthorized","message":"You do not have permissions to select this duck.","code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"}```|

**set-ducks**
_Add a new duck_

|||
|--|--|
|URL|`/set-ducks`|
|Method|`POST`|
|Request Body|```{"name":"Duck","price":"20.00"}```|
|Successful Response|```{"success":true,"response":[{"id":1,"name":"duck","price":10,"created":{"date":"2021-01-20 15:46:02.000000","timezone_type":3,"timezone":"Europe/London"}}]}```|
|Error Response|**Invalid Credentials** <br>```{"name":"Unauthorized","message":"Your request was made with invalid credentials.","code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"}```<br>**Failed Addition**<br>```{"name":"Bad Request","message":"Failed to add new duck.","code":0,"status":400,"type":"yii\\web\\BadRequestHttpException"}```|

_Request Body must be sent as `JSON`_
Required Parameters
|Name|Type|
|--|--|
|Name|`string`|
|Price|`float` `i.e. 20.00`|

**set-ducks/1**
_Update existing duck from provided ID_

|||
|--|--|
|URL|`/set-ducks/<id>`|
|Method|`POST`|
|Request Body|```{"name":"Duck","price":"20.00"}```|
|Successful Response|```{"success":true,"response":[{"id":1,"name":"duck","price":10,"created":{"date":"2021-01-20 15:46:02.000000","timezone_type":3,"timezone":"Europe/London"}}]}```|
|Error Response|**Invalid Credentials** <br>```{"name":"Unauthorized","message":"Your request was made with invalid credentials.","code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"}```<br>**No Record**<br>```{"name":"Bad Request","message":"A duck does not exist with that id.","code":0,"status":400,"type":"yii\\web\\BadRequestHttpException"}```<br>**Not your duck**<br>```{"name":"Unauthorized","message":"You do not have permissions to update this duck.","code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"}```<br>**Failed Update**<br>```{"name":"Bad Request","message":"Failed to update this duck.","code":0,"status":400,"type":"yii\\web\\BadRequestHttpException"}```|

_Request Body must be sent as `JSON`_
Required Parameters
|Name|Type|
|--|--|
|Name|`string`|
|Price|`float` `i.e. 20.00`|

**delete-duck/1**
_Delete a specific duck from supplied ID_

|||
|--|--|
|URL|`/delete-duck/<id>`|
|Method|`POST`|
|Successful Response|```{"success":true}```|
|Error Response|**Invalid Credentials** <br>```{"name":"Unauthorized","message":"Your request was made with invalid credentials.","code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"}```<br>**No Record**<br>```{"name":"Bad Request","message":"A duck does not exist with that id.","code":0,"status":400,"type":"yii\\web\\BadRequestHttpException"}```<br>**Not your duck**<br>```{"name":"Unauthorized","message":"You do not have permissions to remove this duck.","code":0,"status":401,"type":"yii\\web\\UnauthorizedHttpException"}```<br>**Failed Removal**<br>```{"name":"Bad Request","message":"Failed to remove this duck.","code":0,"status":400,"type":"yii\\web\\BadRequestHttpException"}```|