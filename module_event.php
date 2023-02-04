<?
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function DefaultClearClick(&$MenuObj,&$ActionObj,$dataInner){
	if (keyExist($MenuObj,'fieldInner')!='') {
		$fields=preg_replace('/^~(.*)/is', '$1', $MenuObj['fieldInner']);
		if (preg_match('/^~/is', $MenuObj['fieldInner'],$tags)) $ActionObj['fields']=$fields;
		$Fieldby=strKeyValue($fields);
		_Debug_point_($MenuObj['name'],$Fieldby);
		foreach ($Fieldby as $key => $value) {
			$ActionObj[$value]='';
		}
	}
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$dataInner['action']=$MenuObj['name'];
	$dataInner['_afterouter_']=keyExist($MenuObj,'message','');
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function DefaultClearRouteClick(&$MenuObj,&$ActionObj,$dataInner){
	$dataInner=DefaultClearClick($MenuObj,$ActionObj,$dataInner);
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$Answer=MenuRouteItem($MenuObj);
	$dataInner['action']=$MenuObj['name'];
	$dataInner['_afterouter_']=keyExist($MenuObj,'message','');
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($MenuObj,true).PREOL);
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function DefaultClick(&$MenuObj,&$ActionObj,$dataInner){
	if (keyExist($MenuObj,'fieldInner')!='') {
		$fields=preg_replace('/^~(.*)/is', '$1', $MenuObj['fieldInner']);
		if (preg_match('/^~/is', $MenuObj['fieldInner'],$tags)) $ActionObj['fields']=$fields;
		$Fieldby=strKeyValue($fields);
		foreach ($Fieldby as $key => $value) {
			if (isKeyExist($ActionObj,$key)) {
				$ActionObj[$key]=$value;
			} else $ActionObj[$value]='';
		}
	}
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$dataInner['action']=$MenuObj['name'];
	$dataInner['_afterouter_']=keyExist($MenuObj,'message','');
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function DefaultRouteClick(&$MenuObj,&$ActionObj,$dataInner){
	$dataInner=DefaultClick($MenuObj,$ActionObj,$dataInner);
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$Answer=MenuRouteItem($MenuObj);
	$dataInner['action']=$MenuObj['name'];
	$dataInner['_afterouter_']=keyExist($MenuObj,'message','');
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($MenuObj,true).PREOL);
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function DefaultClickerClick(&$MenuObj,&$ActionObj,$dataInner){
	$dataInner=DefaultClick($MenuObj,$ActionObj,$dataInner);
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$Answer=MenuRouteItem($MenuObj);
	$dataInner=BeforeClickMenuItem($MenuObj,$ActionObj,$dataInner);
	$dataInner['action']=$MenuObj['name'];
	$dataInner['_afterouter_']=keyExist($MenuObj,'message','');
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($MenuObj,true).PREOL);
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function DefaultRouteInner($MenuObj,$ActionObj,$dataInner){
	$DataInner=$dataInner['_message_'];
	if (keyExist($MenuObj,'fieldInner')!='') {
		$dataInner['status']=ERR_EMPTY;
		$dataInner[$MenuObj['fieldInner']]=$DataInner;
	} else return ERR_FIELDEMPTY;
	return $dataInner;
}
function DefaultRouteInEvent(&$MenuObj,&$ActionObj,$dataInner){
	// Збереження вибраного особового рахунку
	if (keyExist($dataInner,'status')!=ERR_EMPTY) return $dataInner['status'];
	if (keyExist($MenuObj,'fieldInner')!='') {
		if (!preg_match('/^~/is', $MenuObj['fieldInner'],$tags)) {
			$fieldInner=$MenuObj['fieldInner'];
			$ActionObj[$fieldInner]=$dataInner[$fieldInner];
		}
	}
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$Answer=MenuRouteItem($MenuObj);
	$ActionObj['action']=$MenuObj['name'];
	$dataInner['_afterouter_']=$Answer;
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function StartWorksClick(&$MenuObj,&$ActionObj,$dataInner){
	$ActionObj['active']=1;
	$Answer=MenuRouteItem($MenuObj);
	$dataInner['action']=$MenuObj['name'];
	$dataInner['_afterouter_']=$Answer;
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function CheckitPhoneInner($MenuObj,$ActionObj,$dataInner){
	$PhoneData=$dataInner['_message_'];
	if (preg_match('/^\+\d{5}-\d{3}-\d{2}-\d{2}$/',$PhoneData,$tags)) {
		if (keyExist($MenuObj,'fieldInner')!='') {
			$dataInner['status']=ERR_EMPTY;
			$dataInner[$MenuObj['fieldInner']]=$PhoneData;
		} else return ERR_FIELDEMPTY;
	} else return ERR_PHONESIZE;
	return $dataInner;
}
function CheckPhoneInEvent(&$MenuObj,&$ActionObj,$dataInner){
	global $BUserObj;
	// Збереження вибраного особового рахунку
	if (keyExist($dataInner,'status')!=ERR_EMPTY) return $dataInner['status'];
	$fieldInner=preg_replace('/^~(.*)/is', '$1', $MenuObj['fieldInner']);
	$ActionObj[$fieldInner]=$dataInner[$fieldInner];
	if (isKeyExist($BUserObj,$fieldInner)) $BUserObj[$fieldInner]=$dataInner[$fieldInner];
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$Answer=MenuRouteItem($MenuObj);
	$ActionObj['action']=$MenuObj['name'];
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	// $ActionObj=_EncodeJsonField($ActionObj,'botaction');
	// BotActionSQL(UPDATESQL,['ids'=>$ActionObj['ids']],$ActionObj);
	$BUserObj=_EncodeJsonField($BUserObj,'botuser');
	BotUserSQL(UPDATESQL,['ids'=>$BUserObj['ids']],$BUserObj);
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($MenuObj,true).PREOL);
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function IsActiveClick(&$MenuObj,&$ActionObj,$dataInner){
	$ActionObj['active']=1;
	$Answer=MenuRouteItem($MenuObj);
	$dataInner['action']=$MenuObj['name'];
	$dataInner['_afterouter_']=$Answer;
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function DroppedClick(&$MenuObj,&$ActionObj,$dataInner){
	global $BUserObj;
	if (keyExist($ActionObj,'active')=='1'){
		$ActionObj['active']=0;
		$ActionObj['phone']='';

		$BRoleObj=BotRoleSQL(ASSOCSQL,['name'=>'default']);
		$BUserObj['role']=keyExist($BRoleObj,'ids');
		$BUserObj=_EncodeJsonField($BUserObj,'botuser');
		BotUserSQL(UPDATESQL,['ids'=>$BUserObj['ids']],$BUserObj);
	}
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($ActionObj,true).PREOL);
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function ReportDayClick(&$MenuObj,&$ActionObj,$dataInner){
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$dataInner['action']=$MenuObj['name'];

	$MsgOuter='Відключення на '.date('d-m-Y').LNBR;
	
	$TurnOffObj=['socialoff'=>0,'businessoff'=>0];
	$LastName='';
	$result=TurnOffSQL(SELECTSQL,['property'=>['JSON_VALUE','date',date('Y-m-d')],'order by'=>'name']);
	if (NumRowsSQL($result)>0) {
		while ($obj = FetchSQL(ASSOCSQL,$result)){
			$obj=_DecodeJsonField($obj,'turnoff');
			if ($LastName!=$obj['name']) {
				if ($LastName=='') $MsgOuter.=LNBR;
				$MsgOuter.=LNBR.$obj['name'].LNBR;
				$LastName=$obj['name'];
			}
			$MsgOuter.='~~~ Черга '.$obj['queue'].'('.$obj['time'].')'.' ~~~'.LNBR;
			$MsgOuter.='Побутові :  '.$obj['socialoff'].LNBR;
			$MsgOuter.='Юридичні :  '.$obj['businessoff'].LNBR;
			$TurnOffObj['socialoff']+=$obj['socialoff'];
			$TurnOffObj['businessoff']+=$obj['businessoff'];
		}
		$MsgOuter.='~~~~~~~~~~~~~~~~~~~~'.LNBR;
		$MsgOuter.='Разом '.LNBR.'~~~~~~~~~~~~~~~~~~~~'.LNBR;
		$MsgOuter.='Побутові :  '.$TurnOffObj['socialoff'].LNBR;
		$MsgOuter.='Юридичні :  '.$TurnOffObj['businessoff'].LNBR;
		$MsgOuter.='~~~~~~~~~~~~~~~~~~~~';
	}
	$Answer=MenuRouteItem($MenuObj);
	$ActionObj['action']=$MenuObj['name'];
	$dataInner['_afterouter_']=$MsgOuter.LNBR.LNBR.keyExist($MenuObj,'message','');
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($TurnOff,true).PREOL);
	return $dataInner;
}
function ReportQueueClick(&$MenuObj,&$ActionObj,$dataInner){
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$dataInner['action']=$MenuObj['name'];

	$MaskOuter=$MenuObj['message'].LNBR;
	$MaskOuter=preg_split('/\|/ism',$MaskOuter);
	$MsgOuter='';
	
	$fields=preg_replace('/^~(.*)/is', '$1', $MenuObj['fieldInner']);
	if (preg_match('/\:/is', $MenuObj['fieldInner'],$tags)) {
		$fields=strKeyValue($fields);
	} else $fields=[];
	$GroupBy=strKeyValue(keyExist($fields,'groupby','--gb--'));
	$SumBy=strKEyValue(keyExist($fields,'sumby','--sb--'),';',',');
	$MaxiBy=strKeyValue(keyExist($fields,'maxiby','--mb--'),';',',');
	$FieldBy=Array_merge($GroupBy,$SumBy,$MaxiBy);

	$InnerDate=date('Y-m-d');
	$OuterData=[];
	$OuterSum=[];
	$result=TurnOffSQL(SELECTSQL,['property'=>['JSON_VALUE','date',$InnerDate],'order by'=>'name']);
	if (NumRowsSQL($result)>0) {
		while ($obj = FetchSQL(ASSOCSQL,$result)){
			$obj=_DecodeJsonField($obj,'turnoff');
			$GroupKey=current(keyExist($obj,$GroupBy));
			$FieldsKey=array_intersect_key($obj,array_flip($FieldBy));
			if (isKeyExist($OuterData,$GroupKey)) {
				foreach ($SumBy as $key => $value) {
					$OuterData[$GroupKey][$value]=$OuterData[$GroupKey][$value]+$FieldsKey[$value];
				}
				foreach ($MaxiBy as $key => $value) {
					if ($OuterData[$GroupKey][$value]<$FieldsKey[$value]) {
						$OuterData[$GroupKey][$value]=$FieldsKey[$value];
					}
				}
			} else {
				$OuterData[$GroupKey]=$FieldsKey;
			}
			/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
			foreach ($SumBy as $key => $value) {
				$OuterSum[$value]=$OuterSum[$value]+$FieldsKey[$value];
			}
			foreach ($MaxiBy as $key => $value) {
				if ($OuterSum[$value]<$FieldsKey[$value]) {
					$OuterSum[$value]=$FieldsKey[$value];
				}
			}
			/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
		}
		$MsgOuter=geMaskSwap(KeyExist($MaskOuter,0,''),['date'=>date('d-m-Y')]).LNBR;
		foreach ($OuterData as $GroupKey => $GroupValue) {
			$MsgOuter.=geMaskSwap(KeyExist($MaskOuter,1,''),$GroupValue).LNBR;
			$MsgOuter.=geMaskSwap(KeyExist($MaskOuter,3,''),$GroupValue).LNBR;
		}
		$MsgOuter.=LNBR;
		$MsgOuter.=geMaskSwap(KeyExist($MaskOuter,2,''),$OuterSum).LNBR;
		$MsgOuter.=geMaskSwap(KeyExist($MaskOuter,3,''),$OuterSum).LNBR;
		
		$MsgOuter.=KeyExist($MaskOuter,4,'');
	}
	$Answer=MenuRouteItem($MenuObj);
	$ActionObj['action']=$MenuObj['name'];
	$dataInner['_afterouter_']=$MsgOuter.LNBR.LNBR.keyExist($MenuObj,'message','');
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($TurnOff,true).PREOL);
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function ReportTimeClick(&$MenuObj,&$ActionObj,$dataInner){
	global $BUserObj;
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$dataInner['action']=$MenuObj['name'];
	
	$MaskOuter=$MenuObj['message'].LNBR;
	$MaskOuter=preg_split('/\|/ism',$MaskOuter);
	$MsgOuter='';
	LoggerInsertSQL(echo_logger(true),PREOS.print_r($MaskOuter,true).PREOL);
	$result=TurnOffSQL(SELECTSQL,['property'=>['JSON_VALUE','date',date('Y-m-d')],'order by'=>'name']);
	if (NumRowsSQL($result)>0) {
		while ($obj = FetchSQL(ASSOCSQL,$result)){
			$obj=_DecodeJsonField($obj,'turnoff');
			if ($BUserObj['depart']==$obj['depart']) {
				if ($MsgOuter=='') $MsgOuter.=geMaskSwap(KeyExist($MaskOuter,0,''),$obj).LNBR;
				// LoggerInsertSQL(echo_logger(true),PREOS.print_r($obj['depart'],true).PREOL);
				$MsgOuter.=geMaskSwap(KeyExist($MaskOuter,1,''),$obj).LNBR;
				// $MsgOuter.='Побутові :  '.$obj['socialoff'].LNBR;
				// $MsgOuter.='Юридичні :  '.$obj['businessoff'].LNBR;
			}
		}
		$MsgOuter.=KeyExist($MaskOuter,2,'');
	}
	$Answer=MenuRouteItem($MenuObj);
	$dataInner['action']=$MenuObj['name'];
	$dataInner['_afterouter_']=$MsgOuter.LNBR.LNBR.keyExist($MenuObj,'message','');
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($dataInner,true).PREOL);
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function TurnOffClick(&$MenuObj,&$ActionObj,$dataInner){
	global $BUserObj;
	$dataInner=DefaultClearClick($MenuObj,$ActionObj,$dataInner);
	$DepartObj=DepartsSQL(ASSOCSQL,['ids'=>$BUserObj['depart']]);
	$dataInner['_afterouter_']=geMaskSwap($dataInner['_afterouter_'],['depart'=>keyExist($DepartObj,'name')]);
	LoggerInsertSQL(echo_logger(true),PREOS.print_r($dataInner,true).PREOL);
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function TurnOffQueueClick(&$MenuObj,&$ActionObj,$dataInner){
	$dataInner=DefaultRouteClick($MenuObj,$ActionObj,$dataInner);
	$dataInner=TurnOffClick($MenuObj,$ActionObj,$dataInner);
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($dataInner,true).PREOL);
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function TurnOffRouteClick(&$MenuObj,&$ActionObj,$dataInner){
	$dataInner=DefaultClearRouteClick($MenuObj,$ActionObj,$dataInner);
	$dataInner=TurnOffClick($MenuObj,$ActionObj,$dataInner);
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($dataInner,true).PREOL);
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function TurnOffInner($MenuObj,$ActionObj,$dataInner){
	$MsgInner=$dataInner['_message_'];
	if (keyExist($MenuObj,'fieldInner')!='') {
		$dataInner['status']=ERR_EMPTY;
		$dataInner[$MenuObj['fieldInner']]=$MsgInner;
	} else return ERR_FIELDEMPTY;
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($dataInner,true).PREOL);
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function TurnOffInEvent(&$MenuObj,&$ActionObj,$dataInner){
	// Збереження вибраного особового рахунку
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($dataInner,true).PREOL);
	if (keyExist($dataInner,'status')!=ERR_EMPTY) return $dataInner['status'];
	$fieldInner=$MenuObj['fieldInner'];
	$ActionObj[$fieldInner]=$dataInner[$fieldInner];
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$Answer=MenuRouteItem($MenuObj);
	$dataInner=BeforeClickMenuItem($MenuObj,$ActionObj,$dataInner);
	$ActionObj['action']=$MenuObj['name'];
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function SaveTurnOffClick(&$MenuObj,&$ActionObj,$dataInner){
	global $BUserObj;
	$DepartObj=DepartsSQL(ASSOCSQL,['ids'=>$BUserObj['depart']]);
	$TurnMask=['ids'=>create_guid_size(32),'name'=>keyExist($DepartObj,'name'),
				'date'=>date('Y-m-d'),'time'=>date('H:i:s'),'botuser'=>$BUserObj['name'],
				'depart'=>$BUserObj['depart'],'uptime'=>dateNow(),'active'=>1];
	$fieldsBy=strKeyValue($ActionObj['fields']);
	$valuesBy=array_intersect_key($ActionObj,array_flip($fieldsBy));
	$TurnMask=$TurnMask+$valuesBy;
	$TurnMask=_EncodeJsonField($TurnMask,'turnoff');
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$fieldsBy=preg_replace('/^~(.*)/is', '$1', $MenuObj['fieldInner']);
	if (!preg_match('/^~/is', $MenuObj['fieldInner'],$tags)) $fieldsBy='';
	$fieldsBy=strKeyValue($fieldsBy);
	$valuesBy=array_intersect_key($TurnMask,array_flip($fieldsBy));
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	$TurnOffObj=null;
	// $query=TurnOffSQL(_SELECTSQL,['property'=>['JSON_VALUE','date',date('Y-m-d')],'order by'=>'date DESC']);
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($query,true).PREOL);
	$result=TurnOffSQL(SELECTSQL,['property'=>['JSON_VALUE','date',date('Y-m-d')],'order by'=>'uptime DESC']);
	if (NumRowsSQL($result)>0) {
		while ($obj = FetchSQL(ASSOCSQL,$result)){
			$obj=_DecodeJsonField($obj,'turnoff');
			$CheckBy=array_intersect_assoc($obj,$valuesBy);
			$CheckBy=array_diff_assoc($valuesBy,$CheckBy);
			if (Count($CheckBy)==0) $TurnOffObj=$obj;
		}
	}
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	if ($TurnOffObj==null) TurnOffSQL(INSERTSQL,[],$TurnMask);
	else {
		$TurnMask['ids']=$TurnOffObj['ids'];
		TurnOffSQL(UPDATESQL,['ids'=>$TurnOffObj['ids']],$TurnMask);
	}

	$Answer=MenuRouteItem($MenuObj);
	$dataInner=BeforeClickMenuItem($MenuObj,$ActionObj,$dataInner);

	$dataInner['action']=$MenuObj['name'];
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($DepartObj,true).PREOL);
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($query,true).PREOL);
	// LoggerInsertSQL(echo_logger(true),PREOS.print_r($ActionObj,true).PREOL);
	
	return $dataInner;
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
