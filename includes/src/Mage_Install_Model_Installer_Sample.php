<?php
/**
 * Sample DB Installer
 *
 * @category   Mage
 * @package    Mage_Install
 * @author     SNSTheme.Com 
 */
class Mage_Install_Model_Installer_Sample extends Mage_Install_Model_Installer_Db
{
    /**
     * Instal Sample database
     *
     * $data = array(
     *      [db_host]
     *      [db_name]
     *      [db_user]
     *      [db_pass]
     * )
     *
     * @param array $data
     */

	public function installSampleDB ($data) {
		//Get content from sample data
		//Default sample data
		//$tablePrefix = (string)Mage::getConfig()->getTablePrefix();
		$tablePrefix = $data['db_prefix'];
		$base_url = $data['unsecure_base_url'];
		$base_surl = $base_url;
		if (!empty($data['use_secure'])) $base_surl = $data['secure_base_url'];
		
		/* Run sample_data.sql if found, by pass default sample data from Magento */		
		$file = Mage::getConfig()->getBaseDir().'/data_quickstart/sample_data.sql';
		if (!is_file($file)) {
			$file = Mage::getConfig()->getBaseDir().'/data_quickstart/magento_sample_data_for_1.2.0.sql';
		}
		if (is_file($file)) { //echo $file; die();
			//connect to DB
			$link = mysql_connect($data['db_host'], $data['db_user'], $data['db_pass']);
			if (!$link) {
				//echo  "Please <a href=\"javascript:history.back(-1)\">Go back</a> and update Config<br /><br />";
				//die ("Cannot connect to mysql server.");
				return false;
			}
			if (!mysql_select_db($data['db_name'], $link)) { 
				//close DB connection
				mysql_close ($link);
				//echo  "Please <a href=\"javascript:history.back(-1)\">Go back</a> and update Config<br /><br />";
				//die ("Cannot Connect to Database [{$data['db_name']}]");
				return false; 
			}
			$contents = file_get_contents ($file);
			$sqls = self::parseSQL ($contents);
			//foreach ($sqls as $sql) {
			//	$sql = trim(str_replace ('#__', $tablePrefix, $sql));
			//	var_dump($sql);
			//}
			//die;
			foreach ($sqls as $sql) {
				$sql = trim(str_replace ('#__', $tablePrefix, $sql));
				//Excute this sql				
				if ($sql && !mysql_query($sql, $link)) {
					//close DB connection
					mysql_close ($link);
					//echo  "Please <a href=\"javascript:history.back(-1)\">Go back</a> and update Config<br /><br />";
					//echo "Cannot excute Statment <br />[$sql]<br />Error: [".mysql_errno()."]<br />Error Msg: [".mysql_error()."]";
					//die();
					return false;
				}
			}
			//close DB connection
			mysql_close ($link);
			return true;
		}
		return false;
	}
	
	function parseSQL ($contents) {
		// Remove C style and inline comments
		$comment_patterns = array('/\/\*.*(\n)*.*(\*\/)?/', //C comments
								  '/^\s*--.*\n/', //inline comments start with --
								  '/^\s*#.*\n/', //inline comments start with #
								  );
		$contents = preg_replace($comment_patterns, "\n", $contents);
		//Retrieve sql statements
		$statements = explode(";\n", $contents);
		//$statements = preg_replace("/\s/", ' ', $statements);

		return $statements;
	}
}