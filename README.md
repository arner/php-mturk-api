php-mturk-api 
============= 

PHP library for communicating with the Amazon Mechanical Turk REST API.  

### Structure

The MechanicalTurk class contains the functions that you can use to communicate with the RESTFul API of Amazon Mechanical Turk. Furthermore, there are two classes called [HIT](http://docs.aws.amazon.com/AWSMechTurk/latest/AWSMturkAPI/ApiReference_HITDataStructureArticle.html) and [Assignment](http://docs.aws.amazon.com/AWSMechTurk/latest/AWSMturkAPI/ApiReference_AssignmentDataStructureArticle.html). Both are mostly used for data retention. In most cases, the fields and functions are exact copies from the API. In some cases, it was better to change them. Please refer to the [APIDocs](http://docs.aws.amazon.com/AWSMechTurk/latest/AWSMturkAPI/Welcome.html) for information on the different features. If you miss some functionality, it should be fairly easy to implement your own.

### Currently implemented features

**HITs**  
createHIT  
getReviewableHITs  
getAllHITs (= searchHits)  
searchHITs  
getHIT  
forceExpireHIT  
disableHIT  
disposeHIT  

**Assignments**  
getAssignmentsForHIT  
getAssignment  
approveAssignment  
rejectAssignment  

**Workers**  
getBlockedWorkers  
getRequesterWorkerStatistic  
blockWorker  
unblockWorker  
grantBonus  
notifyWorkers  

**Requester**  
getRequesterStatistic  
getAccountBalance  

**Notifications**  
setHITTypeNotification  
SendTestEventNotification  
setIfActiveHITTypeNotification  

### Usage

First fill out your API keys and settings in config.template.php, and rename to config.php.  

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
