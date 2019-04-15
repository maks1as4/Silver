<?php

class UserIdentity extends CUserIdentity
{
	protected $_id;

	public function authenticate()
	{
		$user = Users::model()->find('LOWER(username)=?', array(strtolower($this->username)));
		if (($user===null) || (md5(Yii::app()->params['salt'].$this->password) !== $user->password) || ($user->status != 0))
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		else
		{
			$this->_id = $user->id;
			$this->setState('username', $user->username);
			$this->setState('email', $user->email);
			$this->setState('avatar', $user->avatar);
			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}