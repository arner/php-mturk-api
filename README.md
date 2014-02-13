php-mturk-api
=============

PHP library for communicating with the Amazon Mechanical Turk REST API.

<h3>Structure</h3>
The MechanicalTurk class contains the functions that you can use to communicate with the RESTFul API of Amazon Mechanical Turk. Furthermore, there are two classes called <a href='http://docs.aws.amazon.com/AWSMechTurk/latest/AWSMturkAPI/ApiReference_HITDataStructureArticle.html'>HIT</a> and <a href='http://docs.aws.amazon.com/AWSMechTurk/latest/AWSMturkAPI/ApiReference_AssignmentDataStructureArticle.html'>Assignment</a>. Both are mostly used for data retention. In most cases, the fields and functions are exact copies from the API. In some cases, it was better to change them. Please refer to the <a href='http://docs.aws.amazon.com/AWSMechTurk/latest/AWSMturkAPI/Welcome.html'>APIDocs</a> for information on the different features. If you miss some functionality, it should be fairly easy to implement your own. 


<h3>Currently implemented features</h3>
<b>HITs</b><br>
createHIT<br>
getReviewableHITs<br>
getAllHITs (= searchHits)<br>
searchHITs<br>
getHIT<br>
forceExpireHIT<br>
disableHIT<br>
disposeHIT<br>
<br>
<b>Assignments</b><br>
getAssignmentsForHIT<br>
getAssignment<br>
approveAssignment<br>
rejectAssignment<br>
<br>
<b>Workers</b><br>
getBlockedWorkers<br>
getRequesterWorkerStatistic<br>
blockWorker<br>
unblockWorker<br>
grantBonus<br>
notifyWorkers<br>
<br>
<b>Requester</b><br>
getRequesterStatistic<br>
getAccountBalance<br>
<br>
<b>Notifications</b><br>
setHITTypeNotification<br>
SendTestEventNotification<br>
setIfActiveHITTypeNotification<br>
<h3>Usage</h3>
First fill out your API keys and settings in config.template.php, and rename to config.php.<br>
<br>
Instantiate
```php
require_once('MechanicalTurk.class.php')
$mturk = new MechanicalTurk();
```
Retrieve all your HITs.
```php
print_r($mturk->getAllHITs());
```
Retrieve a Hit object and convert it to an array for easy access.
```php
$hit = $mturk->getHIT('THE_HIT_ID');
$array = $hit->toArray();
print_r($array);
```
Please refer to mturk-example.php for info on HIT creation.
