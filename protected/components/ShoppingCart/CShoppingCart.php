<?php
/**
 * Корзина LAVRIK CMS
 * по всем вопросам на valery-lavrik@yandex.ru
 * или на www.lavrik-v.ru
 * ссылка на скрипт lavrik-v.ru/info/188/Yii_framework___korzina_LavrikShoppingCart__na_sessiyax.html
 */

class CShoppingCart
{
	/*
	$basket[ номер ]['id']			- уникальный идентификатор позиции в сессии (он-же id товара в базе)
	$basket[ номер ]['count']		- количество данного товара
	$basket[ номер ]['price']		- цена товара
	$basket[ номер ]['vkl']			- флаг отключающий товар в сессии
	*/

	private $name_row_name = 'name'; // Название поля из базы в котором сидит наименование товара
	private $name_row_url = 'url'; // Название поля из базы в котором сидит URL
	private $name_row_prise = 'price'; // Название поля из базы в котором сидит цена

	public $sum; // общая сумма товаров
	public $count_in_basket; // общее число товаров
	public $count_of_different_products; // количество разных видов товаров

	// ******************************************************************************** //
	// Это типа конструктор, для подсчета всех цифирек....
	public function init()
	{
		$this->recalculation();
	}

	// ******************************************************************************** //
	// Служебный метод. Просто пересчитывает регистры
	public function recalculation()
	{
		/*Функция просматривает сессию, заносит все в массив и пересчитывает данные*/
		$this -> sum = 0;
		$this -> count_in_basket = 0;
		$this -> count_of_different_products = 0;

		if (!empty(Yii::app()->session['bascket']))
		{
			$TempBasket=Yii::app()->session['bascket'];
			for ($k=0;$k<sizeof($TempBasket);$k++)
			{
				if ($TempBasket[$k]['vkl'])
				{
					$temp = $TempBasket[$k]['price']*$TempBasket[$k]['count'];
					$this -> sum += $temp;
					$this -> count_in_basket += $TempBasket[$k]['count'];
					$this -> count_of_different_products += 1;
				}
			}
		}
	}

	// ******************************************************************************** //	
	// Положить в корзину товар с id==$id, $count штук...
	public function put($position, $count)
	{
		// Наименование товара
		$n = $this->name_row_name;
		$name = $position->$n;

		// URL
		$u = $this->name_row_url;
		$url = $position->$u;

		// Тут нахожу цену. Если нужно с учетом какойнибудь скидки, то меняется здесь.
		$pr = $this->name_row_prise;
		$price = $position->$pr;

		/* Добавляю в корзину товар */
		if (is_numeric($count))
		{
			if (!empty(Yii::app()->session['bascket']))
			{
				/*Если сессия есть, добавляю в нее товар*/
				$bascket = Yii::app()->session['bascket'];
				$notAdded = false;

				/*Если такой товар уже есть, то тупо его плюсую...*/
				for ($k=0;$k<sizeof($bascket);$k++)
				{
					if ($bascket[$k]['vkl'])
					{
						if (trim($bascket[$k]['id']) == trim($position->getPrimaryKey()))
						{
							// Тут обновление (добавление к имеющимся) колличества товара на позицию
							// $bascket[$k]['count'] += $count;
							// Нужно изменять, удалять пред. кол. и записывать новое
							$bascket[$k]['count'] = $count;
							$notAdded = true;
						}
					}
				}

				/*Если дубликата не нашел то добавляю новую такую позицию...*/
				if (!$notAdded)
				{
					$bascket[] = array(
						'id' => $position->getPrimaryKey(),
						'name' => $name,
						'url' => $url,
						'count' => $count,
						'price' => $price,
						'vkl' => true,
					);
				}
			}
			else
			{
				/*Если сессии нет, создаю её*/
				$bascket[] = array(
					'id' => $position->getPrimaryKey(),
					'name' => $name,
					'url' => $url,
					'count' => $count,
					'price' => $price,
					'vkl' => true,
				);
			}
			Yii::app()->session['bascket'] = $bascket;
			$this->recalculation();
		}
	}

	// ******************************************************************************** //
	// Изменить количиство позиции с id==$id на $count
	function updateCountInBascet($id = null, $count)
	{
		/* Изменить число товара в корзине.. */
		if (!empty(Yii::app()->session['bascket']) AND $id)
		{
			$TempBasket=Yii::app()->session['bascket'];
			for ($k=0;$k<sizeof($TempBasket);$k++)
			{
				if ($TempBasket[$k]['id'] == $id)
				{
					$TempBasket[$k]['count'] = $count;
				}
			}
			Yii::app()->session['bascket'] = $TempBasket;
			$this -> recalculation();
		}
	}

	// ******************************************************************************** //
	// Получить сумму по определённой позиции
	public function getSumToPosition($id = null)
	{
		$temp = 0;
		if (!empty(Yii::app()->session['bascket']) AND $id)
		{
			$TempBasket = Yii::app()->session['bascket'];
			for ($k=0;$k<sizeof($TempBasket);$k++)
			{
				if ($TempBasket[$k]['vkl'] AND $TempBasket[$k]['id'] == $id)
				{
					//$temp = (int)($TempBasket[$k]['count'] * $TempBasket[$k]['price']);
					$temp = $TempBasket[$k]['count'] * $TempBasket[$k]['price'];
				}
			}
		}
		return $temp;
	}

	// ******************************************************************************** //
	// Удаляем из корзины товар
	function delFromBasket($id)
	{
		/* Удалить товар из корзины.. */
		if (!empty(Yii::app()->session['bascket']))
		{
			$TempBasket = Yii::app()->session['bascket'];
			for ($k=0;$k<sizeof($TempBasket);$k++)
			{
				if ($TempBasket[$k]['id'] == $id)
				{
					$TempBasket[$k]['vkl'] = false;
				}
			}
			Yii::app()->session['bascket'] = $TempBasket;
		}

		// Если в сессии отключены все позиции, то удаляю сессию
		if (!empty(Yii::app()->session['bascket']))
		{
			$delSession = true;
			$TempBasket = Yii::app()->session['bascket'];
			for ($k=0;$k<sizeof($TempBasket);$k++)
			{
				if ($TempBasket[$k]['vkl'])
				{
					$delSession = false;
				}
			}
			if ($delSession)
				$this->clear();
		}
		$this->recalculation();
	}

	// ******************************************************************************** //
	// Функция для получения массива товаров (если id равен 0) или конкретной позиции (если указан id)
	public function getShoppingList($id = null)
	{
		$temp = array();

		if (!empty(Yii::app()->session['bascket']) AND count(Yii::app()->session['bascket']))
		{
			$positions = Yii::app()->session['bascket'];
			for ($k=0;$k<sizeof($positions);$k++)
			{
				if (!$positions[$k]['vkl']) continue; // пропускаю удаленные позиции
				if ($id)
				{
					if ($positions[$k]['id'] == $id )
					{
						$temp[] = $positions[$k];
					}
				}
				else
				{
					$temp[] = $positions[$k];
				}
			}
		}

		if (count($temp))
		{
			return $temp;
		}
		else
		{
			return false;
		}
	}

	// ******************************************************************************** //
	// Метод проверяет есть ли в корзине товар с id == $id.
	// Если не задавать id, то проверяет пустая корзина или нет....
	public function isset_in_basket($id)
	{
		if (!empty(Yii::app()->session['bascket']) AND count(Yii::app()->session['bascket']))
		{
			$positions = Yii::app()->session['bascket'];
			for ($k=0;$k<sizeof($positions);$k++)
			{
				if (!$positions[$k]['vkl']) continue; // пропускаю
				if ($id)
				{
					if ($positions[$k]['id'] == $id)
					{
						return true; // Позиция с этим id найдена
					}
				}
				else
				{
					return true; // id на задан, но всеравно что-то нашел...
				}
			}
			return false;
		}
	}

	// ******************************************************************************** //
	public function clear()
	{
		$this->sum = 0;
		$this->count_in_basket = 0;
		$this->count_of_different_products = 0;
		unset (Yii::app()->session['bascket']);
	}
}