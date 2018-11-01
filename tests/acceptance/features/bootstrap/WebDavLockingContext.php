<?php
/**
 * ownCloud
 *
 * @author Artur Neumann <artur@jankaritech.com>
 * @copyright Copyright (c) 2018 Artur Neumann artur@jankaritech.com
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License,
 * as published by the Free Software Foundation;
 * either version 3 of the License, or any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>
 *
 */

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use TestHelpers\WebDavHelper;

require_once 'bootstrap.php';

/**
 * context containing API steps needed for the locking mechanism of webdav
 */
class WebDavLockingContext implements Context {

	/**
	 *
	 * @var FeatureContext
	 */
	private $featureContext;

	/**
	 * @When the user :user locks the (file|folder) :file using the WebDAV API setting following properties
	 * @Given the user :user has locked the file/folder :file setting following properties
	 */
	public function lockFileUsingWebDavAPI($user, $file, TableNode $properties) {
		$baseUrl = $this->featureContext->getBaseUrl();
		$password = $this->featureContext->getPasswordForUser($user);
		$body
			= "<?xml version='1.0' encoding='UTF-8'?>\n" .
			"		<d:lockinfo xmlns:d='DAV:'>\n";
			
		if ($properties !== null) {
			$propertiesRows = $properties->getRows();
			foreach ($propertiesRows as $property) {
				$body .= "			<d:$property[0]><d:$property[1]/></d:$property[0]>\n";
			}
		}
		$body .= "		</d:lockinfo>";
		$response = WebDavHelper::makeDavRequest(
			$baseUrl, $user, $password, "LOCK", $file, null, $body, null,
			$this->featureContext->getDavPathVersion()
		);
		$this->featureContext->setResponse($response);
	}

	/**
	 * This will run before EVERY scenario.
	 * It will set the properties for this object.
	 *
	 * @BeforeScenario
	 *
	 * @param BeforeScenarioScope $scope
	 *
	 * @return void
	 */
	public function before(BeforeScenarioScope $scope) {
		// Get the environment
		$environment = $scope->getEnvironment();
		// Get all the contexts you need in this context
		$this->featureContext = $environment->getContext('FeatureContext');
	}
}
