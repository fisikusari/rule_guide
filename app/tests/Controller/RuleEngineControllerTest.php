<?php
namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RuleEngineControllerTest extends WebTestCase
{
    public function testUpload()
    {
			$uploadedFile = new UploadedFile(
				__DIR__.'/../files/yarn.lock',
				'yarn.lock'
			);
			
			$client = static::createClient();
			$client->request('POST', '/rule-engine', [
				"email" => "fisnik@kutia.net",
				"password" => "e7aa8EPHrcMww7q",
				"repositoryName" => "Add Commit name",
				"commitName" => "This is test commit",
			], [
				'file' => $uploadedFile
			]);
			
			$this->assertResponseIsSuccessful();
		}
		
    public function testValidation()
    {
			$uploadedFile = new UploadedFile(
				__DIR__.'/../files/yarn.lock',
				'yarn.lock'
			);
			
			$client = static::createClient();
			$client->request('POST', '/rule-engine', [
				"email" => "fisnik@kutia.net \n",
				"password" => "e7aa8EPHrcMww7q",
				"repositoryName" => "Add Commit name",
				"commitName" => "This is test commit",
			], [
				'file' => $uploadedFile
			]);
			
			$this->assertResponseStatusCodeSame(422);
    }
}