<?php
require_once('php-mturk-api/MechanicalTurk.class.php');

// Fill out your credentials in config.php.
//$example = new Example;
//$example->createHit();

 
class Example {

	private $mturk;
	
	public function __construct(){
		$this->mturk = new MechanicalTurk();
	}

	
	public function setNotificationOfTheFirstHITTypeToInactive(){
		// Not a very useful function, but it demonstrates how to get all the HITs as well as the Notification operation.
		$hits = $this->mturk->getAllHITs();
		$hit = $this->mturk->getHIT($hits[0]);
		$this->mturk->setIfActiveHITTypeNotification($hit->getHITTypeId(), false);
	}


	public function createHIT(){
		//A HTMLQuestion should be in this format. Other types are QuestionForm and ExternalQuestion 
		//(http://docs.aws.amazon.com/AWSMechTurk/latest/AWSMturkAPI/ApiReference_QuestionAnswerDataArticle.html)
		$question = 
		"<?xml version='1.0' ?>
		<HTMLQuestion xmlns='http://mechanicalturk.amazonaws.com/AWSMechanicalTurkDataSchemas/2011-11-11/HTMLQuestion.xsd'>
		  <HTMLContent><![CDATA[
			<!DOCTYPE html>
			<html>
			 <head>
			  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
			  <script type='text/javascript' src='https://s3.amazonaws.com/mturk-public/externalHIT_v1.js'></script>
			 </head>
			 <body>
			  <form name='mturk_form' method='post' id='mturk_form' action='https://www.mturk.com/mturk/externalSubmit'>
			  <input type='hidden' value='' name='assignmentId' id='assignmentId'/>
			  <h1>What's up?</h1>
			  <p><textarea name='Q1' cols='80' rows='3'></textarea></p>
			   <p><input name='Q2' type='text'/></p>
			  <p><input type='submit' id='submitButton' value='Submit' /></p></form>
			  <script language='Javascript'>turkSetAssignmentID();</script>
			 </body>
			</html>
			]]>
		  </HTMLContent>
		  <FrameHeight>450</FrameHeight>
		</HTMLQuestion>
		";

		// Instantiate and fill a new HIT Object. 
		$hit = new Hit();
		$hit->setTitle('Title');
		$hit->setDescription('This is an example.');
		$hit->setKeywords('some, keywords, separated, by, commas');
		$hit->setReward(array('Amount' => 0.01, 'CurrencyCode' => 'USD')); 
		$hit->setAssignmentDurationInSeconds(60);
		$hit->setAutoApprovalDelayInSeconds(86400);
		$hit->setLifetimeInSeconds(86400); 
		$hit->setMaxAssignments(1);
		$hit->setQuestion($question);
		
		/*
		// Instead of a question, you can also use a HITLayoutId and LayoutParameters.
		$hit->setHITLayoutId('20L11K274J7CJ22DALE49UXXXXXXXXX'); // Found in the GUI. 
		$hit->setLayoutParameters(array('sentence'=>'This sentence is just an example', 
										'term1'=>'sentence',
										'term2'=>'example'));
										
		*/
		
		
		// Workers can only do the assignment if they qualify.
		$hit->setQualificationRequirement(array(
											  array('QualificationTypeId' => '000000000000000000L0', //AssignmentsApproved. See APIdocs for more.
													'Comparator' => 'GreaterThan',
													'IntegerValue' => '90',
													'RequiredToPreview' => '90'),
											  array('QualificationTypeId' => '00000000000000000071', //Country.
													'Comparator' => 'EqualTo',
													'LocaleValue' => 'US'))); 						// ISO 3166. http://www.iso.org/iso/country_codes/iso_3166_code_lists.htm	

		
		// Gold standard questions and what to do with them. 
		$hit->setAssignmentReviewPolicy(array(												
										'AnswerKey' => array(	'Q1' => 'answer1', 								// AnswerKey is mandatory. 
																'Q2' => 'answer2'), 							// QuestionId => Correct answer
										'Parameters' => array(	'RejectIfKnownAnswerScoreIsLessThan' => 100,	// %
																'RejectReason' => 'Too many mistakes, sorry.')	// Worker will see this in the comment.		
										)); 
		
		
		
		// Create the HIT. It will be published right away.
		try {
			echo "Created HIT with the ID " . $this->mturk->createHIT($hit) . ".";
		} catch (AMTException $e) {
			echo $e->getMessage();
		}
	}



	public function getAllAnswersToHIT(){
		try {
		$result = $this->mturk->getAssignmentsForHIT('2GKMIKMN9U8S8A9F29NXL3SUAF5XXX');
		} catch (AMTException $e) {
			echo $e->getMessage();
		}
		
		foreach($result as $r){
			print_r($r->getAnswer()); // See the Assignment class for the getters.
		}
		
	}

}



?>
