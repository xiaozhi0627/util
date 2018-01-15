<?php

namespace Gwantsi\Utils;

class BankCard
{
		
	/* 验证银行卡正确性
	 * @param 银行卡号，仅支持 16位，18位，19位
	 * Return Bool
	 */
	static public function checkCard($bankCardNum){
		$ary = str_split($bankCardNum);
		$leath = count($ary);
		if($leath != 16 && $leath != 18 && $leath != 19){
			return false;
		}
		$lastNo = $ary[$leath - 1];
		unset($ary[$leath - 1]);
		
		//计算校验码
		$luhmNum = 0;
		$leath = $leath - 1;
		$ary = array_reverse($ary);
		for($i = 0;$i<$leath;$i++){
			if(($i+1)%2 != 0){
				$newNum = $ary[$i] * 2;
				if($newNum > 9){
					$new = 0;
					$a = str_split($newNum);
					foreach($a as $n){
						$new += $n;
					}
				} else {
					$new = $newNum;
				}
				$luhmNum += $new;
			} else {
				$luhmNum += $ary[$i];
			}
		}
		//echo "$luhmNum += $lastNo";exit;
		$luhmNum += $lastNo;
		//echo $luhmNum;exit;
		//检测校验码
		if($luhmNum % 10 == 0){
			return true;
		} else {
			return false;
		}
	}
	
	//检查并获取银行卡的所属类型
	static public function checkCardType($bankCardNum,$bankCode){
		$bankBinList = self::getBinList($bankCode);
		if(!$bankBinList){
			return false;
		}
		//获取bin code 长度数组
		$binCodeList = array();
		foreach($bankBinList as $bankBin=>$cardType){
			$len = strlen("$bankBin");
			if(!isset($binCodeList[$len]) || !$binCodeList[$len]){
				$binCodeList[$len] = substr($bankCardNum,0,$len);
			}
		}
		if(!$binCodeList){
			return false;
		}
		foreach($binCodeList as $len=>$binCode){
			if(isset($bankBinList[$binCode]) && $bankBinList[$binCode]){
				return $bankBinList[$binCode];
			}
		}
		return false;
	}
	
	//银行编号列表
	static public function getBankList(){
		$list = [
			'100'=>'中国邮政储蓄银行',
			'102'=>'工商银行',
			'103'=>'农业银行',
			'104'=>'中国银行',
			'105'=>'建设银行',
			'301'=>'交通银行',
			'305'=>'民生银行',
			'306'=>'广发银行',
			'308'=>'招商银行',
			'309'=>'兴业银行',
			'310'=>'浦发银行',
			];
		return $list;
	}
	
	/*
	 * 各大银行卡BIN
	 */
	
	//获取银行的Bin list
	static public function getBinList($bankCode){
		if(!$bankCode){
			return array();
		}
		
		$bankAry = array(
			//中国邮政储蓄银行
			'100' => array(
				'62215049'=>'绿卡储蓄卡(银联卡)',
				'62215050'=>'绿卡储蓄卡(银联卡)',
				'62215051'=>'绿卡储蓄卡(银联卡)',
				'62218850'=>'绿卡储蓄卡(银联卡)',
				'62218851'=>'绿卡储蓄卡(银联卡)',
				'62218849'=>'绿卡储蓄卡(银联卡)',
				'622150'=>'绿卡银联标准卡',
				'622151'=>'绿卡银联标准卡',
				'622188'=>'绿卡银联标准卡',
				'622199'=>'绿卡银联标准卡',
				'621096'=>'绿卡通',
				'621098'=>'绿卡通',
				'622810'=>'银联标准贷记卡',
				'622811'=>'银联标准贷记卡',
				'621797'=>'IC联名卡',
				'621799'=>'IC绿卡通',
				'621798'=>'IC绿卡通VIP卡',
				'620529'=>'IC预付费卡',
				'621599'=>'福农卡',
				'955100'=>'绿卡(银联卡)',
				'621095'=>'绿卡VIP卡',
				'622181'=>'绿卡专用卡',
				'621674'=>'普通高中学生资助卡',
				'625919'=>'上海购物信用卡',
				'621622'=>'武警军人保障卡',
				'622812'=>'银联标准白金卡',
				'628310'=>'银联标准公务卡',
				'620062'=>'银联标准卡',
				'623219'=>'中国旅游卡(金卡)',
				'623218'=>'中国旅游卡(普卡)',
				'621285'=>'中职学生资助卡',
			),
			//工商银行
			'102' => array(
				'620302'=>'牡丹灵通卡',
				'620402'=>'牡丹灵通卡',
				'620403'=>'牡丹灵通卡',
				'620404'=>'牡丹灵通卡',
				'620406'=>'牡丹灵通卡',
				'620407'=>'牡丹灵通卡',
				'620409'=>'牡丹灵通卡',
				'620410'=>'牡丹灵通卡',
				'620411'=>'牡丹灵通卡',
				'620412'=>'牡丹灵通卡',
				'620502'=>'牡丹灵通卡',
				'620503'=>'牡丹灵通卡',
				'620405'=>'牡丹灵通卡',
				'620408'=>'牡丹灵通卡',
				'620512'=>'牡丹灵通卡',
				'620602'=>'牡丹灵通卡',
				'620604'=>'牡丹灵通卡',
				'620607'=>'牡丹灵通卡',
				'620611'=>'牡丹灵通卡',
				'620612'=>'牡丹灵通卡',
				'620704'=>'牡丹灵通卡',
				'620706'=>'牡丹灵通卡',
				'620707'=>'牡丹灵通卡',
				'620708'=>'牡丹灵通卡',
				'620709'=>'牡丹灵通卡',
				'620710'=>'牡丹灵通卡',
				'620609'=>'牡丹灵通卡',
				'620712'=>'牡丹灵通卡',
				'620713'=>'牡丹灵通卡',
				'620714'=>'牡丹灵通卡',
				'620802'=>'牡丹灵通卡',
				'620711'=>'牡丹灵通卡',
				'620904'=>'牡丹灵通卡',
				'620905'=>'牡丹灵通卡',
				'621001'=>'牡丹灵通卡',
				'620902'=>'牡丹灵通卡',
				'621103'=>'牡丹灵通卡',
				'621105'=>'牡丹灵通卡',
				'621106'=>'牡丹灵通卡',
				'621107'=>'牡丹灵通卡',
				'621102'=>'牡丹灵通卡',
				'621203'=>'牡丹灵通卡',
				'621204'=>'牡丹灵通卡',
				'621205'=>'牡丹灵通卡',
				'621206'=>'牡丹灵通卡',
				'621207'=>'牡丹灵通卡',
				'621208'=>'牡丹灵通卡',
				'621209'=>'牡丹灵通卡',
				'621210'=>'牡丹灵通卡',
				'621302'=>'牡丹灵通卡',
				'621303'=>'牡丹灵通卡',
				'621202'=>'牡丹灵通卡',
				'621305'=>'牡丹灵通卡',
				'621306'=>'牡丹灵通卡',
				'621307'=>'牡丹灵通卡',
				'621309'=>'牡丹灵通卡',
				'621311'=>'牡丹灵通卡',
				'621313'=>'牡丹灵通卡',
				'621211'=>'牡丹灵通卡',
				'621315'=>'牡丹灵通卡',
				'621404'=>'牡丹灵通卡',
				'621405'=>'牡丹灵通卡',
				'621406'=>'牡丹灵通卡',
				'621407'=>'牡丹灵通卡',
				'621408'=>'牡丹灵通卡',
				'621409'=>'牡丹灵通卡',
				'621410'=>'牡丹灵通卡',
				'621502'=>'牡丹灵通卡',
				'621317'=>'牡丹灵通卡',
				'621511'=>'牡丹灵通卡',
				'621602'=>'牡丹灵通卡',
				'621603'=>'牡丹灵通卡',
				'621604'=>'牡丹灵通卡',
				'621605'=>'牡丹灵通卡',
				'621608'=>'牡丹灵通卡',
				'621609'=>'牡丹灵通卡',
				'621610'=>'牡丹灵通卡',
				'621611'=>'牡丹灵通卡',
				'621612'=>'牡丹灵通卡',
				'621613'=>'牡丹灵通卡',
				'621614'=>'牡丹灵通卡',
				'621615'=>'牡丹灵通卡',
				'621616'=>'牡丹灵通卡',
				'621617'=>'牡丹灵通卡',
				'621607'=>'牡丹灵通卡',
				'621606'=>'牡丹灵通卡',
				'621804'=>'牡丹灵通卡',
				'621807'=>'牡丹灵通卡',
				'621813'=>'牡丹灵通卡',
				'621814'=>'牡丹灵通卡',
				'621817'=>'牡丹灵通卡',
				'621901'=>'牡丹灵通卡',
				'621904'=>'牡丹灵通卡',
				'621905'=>'牡丹灵通卡',
				'621906'=>'牡丹灵通卡',
				'621907'=>'牡丹灵通卡',
				'621908'=>'牡丹灵通卡',
				'621909'=>'牡丹灵通卡',
				'621910'=>'牡丹灵通卡',
				'621911'=>'牡丹灵通卡',
				'621912'=>'牡丹灵通卡',
				'621913'=>'牡丹灵通卡',
				'621915'=>'牡丹灵通卡',
				'622002'=>'牡丹灵通卡',
				'621903'=>'牡丹灵通卡',
				'622004'=>'牡丹灵通卡',
				'622005'=>'牡丹灵通卡',
				'622006'=>'牡丹灵通卡',
				'622007'=>'牡丹灵通卡',
				'622008'=>'牡丹灵通卡',
				'622010'=>'牡丹灵通卡',
				'622011'=>'牡丹灵通卡',
				'622012'=>'牡丹灵通卡',
				'621914'=>'牡丹灵通卡',
				'622015'=>'牡丹灵通卡',
				'622016'=>'牡丹灵通卡',
				'622003'=>'牡丹灵通卡',
				'622018'=>'牡丹灵通卡',
				'622019'=>'牡丹灵通卡',
				'622020'=>'牡丹灵通卡',
				'622102'=>'牡丹灵通卡',
				'622103'=>'牡丹灵通卡',
				'620200'=>'牡丹灵通卡',
				'622013'=>'牡丹灵通卡',
				'622111'=>'牡丹灵通卡',
				'622114'=>'牡丹灵通卡',
				'622017'=>'牡丹灵通卡',
				'622110'=>'牡丹灵通卡',
				'622303'=>'牡丹灵通卡',
				'622304'=>'牡丹灵通卡',
				'622305'=>'牡丹灵通卡',
				'622306'=>'牡丹灵通卡',
				'622307'=>'牡丹灵通卡',
				'622308'=>'牡丹灵通卡',
				'622309'=>'牡丹灵通卡',
				'622314'=>'牡丹灵通卡',
				'622315'=>'牡丹灵通卡',
				'622317'=>'牡丹灵通卡',
				'622302'=>'牡丹灵通卡',
				'622402'=>'牡丹灵通卡',
				'622403'=>'牡丹灵通卡',
				'622404'=>'牡丹灵通卡',
				'622313'=>'牡丹灵通卡',
				'622504'=>'牡丹灵通卡',
				'622505'=>'牡丹灵通卡',
				'622509'=>'牡丹灵通卡',
				'622513'=>'牡丹灵通卡',
				'622517'=>'牡丹灵通卡',
				'622502'=>'牡丹灵通卡',
				'622604'=>'牡丹灵通卡',
				'622605'=>'牡丹灵通卡',
				'622606'=>'牡丹灵通卡',
				'622510'=>'牡丹灵通卡',
				'622703'=>'牡丹灵通卡',
				'622715'=>'牡丹灵通卡',
				'622806'=>'牡丹灵通卡',
				'622902'=>'牡丹灵通卡',
				'622903'=>'牡丹灵通卡',
				'622706'=>'牡丹灵通卡',
				'621304'=>'牡丹灵通卡',
				'621402'=>'牡丹灵通卡',
				'623008'=>'牡丹灵通卡',
				'623011'=>'牡丹灵通卡',
				'623012'=>'牡丹灵通卡',
				'622904'=>'牡丹灵通卡',
				'623015'=>'牡丹灵通卡',
				'623100'=>'牡丹灵通卡',
				'623202'=>'牡丹灵通卡',
				'623301'=>'牡丹灵通卡',
				'623400'=>'牡丹灵通卡',
				'623500'=>'牡丹灵通卡',
				'623602'=>'牡丹灵通卡',
				'623803'=>'牡丹灵通卡',
				'623901'=>'牡丹灵通卡',
				'623014'=>'牡丹灵通卡',
				'624100'=>'牡丹灵通卡',
				'624200'=>'牡丹灵通卡',
				'624301'=>'牡丹灵通卡',
				'624402'=>'牡丹灵通卡',
				'623700'=>'牡丹灵通卡',
				'624000'=>'牡丹灵通卡',
				'622104'=>'牡丹灵通卡',
				'622105'=>'牡丹灵通卡',
				'623002'=>'牡丹灵通卡',
				'623006'=>'牡丹灵通卡',
				'623062'=>'借记卡',
				'621376'=>'借记卡',
				'621423'=>'借记卡',
				'621428'=>'借记卡',
				'621434'=>'借记卡',
				'621761'=>'借记卡',
				'621749'=>'借记卡',
				'621300'=>'借记卡',
				'621378'=>'借记卡',
				'621379'=>'借记卡',
				'621720'=>'借记卡',
				'621762'=>'借记卡',
				'621240'=>'借记卡',
				'621724'=>'借记卡',
				'621371'=>'借记卡',
				'621414'=>'借记卡',
				'621375'=>'借记卡',
				'621734'=>'借记卡',
				'621433'=>'借记卡',
				'621370'=>'借记卡',
				'621733'=>'借记卡',
				'621732'=>'借记卡',
				'621764'=>'借记卡',
				'621372'=>'借记卡',
				'621765'=>'借记卡',
				'621369'=>'借记卡',
				'621750'=>'借记卡',
				'621377'=>'借记卡',
				'621367'=>'借记卡',
				'621374'=>'借记卡',
				'621781'=>'借记卡',
				'625929'=>'贷记卡',
				'625927'=>'贷记卡',
				'625930'=>'贷记卡',
				'625114'=>'贷记卡',
				'625021'=>'贷记卡',
				'625022'=>'贷记卡',
				'622159'=>'贷记卡',
				'625932'=>'贷记卡',
				'625931'=>'贷记卡',
				'625113'=>'贷记卡',
				'625914'=>'贷记卡',
				'625928'=>'贷记卡',
				'625986'=>'贷记卡',
				'625925'=>'贷记卡',
				'625921'=>'贷记卡',
				'625926'=>'贷记卡',
				'625917'=>'贷记卡',
				'622158'=>'贷记卡',
				'625922'=>'贷记卡',
				'625933'=>'贷记卡',
				'625920'=>'贷记卡',
				'625924'=>'贷记卡',
				'620054'=>'预付卡',
				'620142'=>'预付卡',
				'620114'=>'预付卡',
				'620146'=>'预付卡',
				'620143'=>'预付卡',
				'620149'=>'预付卡',
				'620187'=>'预付卡',
				'620124'=>'预付卡',
				'620183'=>'预付卡',
				'620094'=>'预付卡',
				'620186'=>'预付卡',
				'620046'=>'预付卡',
				'620148'=>'预付卡',
				'620185'=>'预付卡',
				'427018'=>'牡丹VISA信用卡',
				'427020'=>'牡丹VISA信用卡',
				'427029'=>'牡丹VISA信用卡',
				'427030'=>'牡丹VISA信用卡',
				'427039'=>'牡丹VISA信用卡',
				'438125'=>'牡丹VISA信用卡',
				'427062'=>'牡丹VISA信用卡',
				'427064'=>'牡丹VISA信用卡',
				'622202'=>'E时代卡',
				'622203'=>'E时代卡',
				'622926'=>'E时代卡',
				'622927'=>'E时代卡',
				'622928'=>'E时代卡',
				'622210'=>'准贷记卡(个普)',
				'622211'=>'准贷记卡(个普)',
				'622212'=>'准贷记卡(个普)',
				'622213'=>'准贷记卡(个普)',
				'622214'=>'准贷记卡(个普)',
				'526836'=>'国航知音牡丹信用卡',
				'513685'=>'国航知音牡丹信用卡',
				'543098'=>'国航知音牡丹信用卡',
				'458441'=>'国航知音牡丹信用卡',
				'402791'=>'国际借记卡',
				'427028'=>'国际借记卡',
				'427038'=>'国际借记卡',
				'548259'=>'国际借记卡',
				'622200'=>'灵通卡',
				'621722'=>'灵通卡',
				'621723'=>'灵通卡',
				'621721'=>'灵通卡',
				'356879'=>'牡丹JCB信用卡',
				'356880'=>'牡丹JCB信用卡',
				'356881'=>'牡丹JCB信用卡',
				'356882'=>'牡丹JCB信用卡',
				'62451804'=>'牡丹贷记卡',
				'62451810'=>'牡丹贷记卡',
				'62451811'=>'牡丹贷记卡',
				'62458071'=>'牡丹贷记卡',
				'451804'=>'牡丹贷记卡(银联卡)',
				'451810'=>'牡丹贷记卡(银联卡)',
				'451811'=>'牡丹贷记卡(银联卡)',
				'458071'=>'牡丹贷记卡(银联卡)',
				'622231'=>'牡丹卡(个人卡)',
				'622232'=>'牡丹卡(个人卡)',
				'622233'=>'牡丹卡(个人卡)',
				'622234'=>'牡丹卡(个人卡)',
				'622929'=>'理财金账户',
				'622930'=>'理财金账户',
				'622931'=>'理财金账户',
				'528856'=>'牡丹多币种卡',
				'524374'=>'牡丹多币种卡',
				'550213'=>'牡丹多币种卡',
				'622237'=>'牡丹交通卡',
				'622239'=>'牡丹交通卡',
				'622238'=>'牡丹交通卡',
				'622223'=>'牡丹卡(商务卡)',
				'622229'=>'牡丹卡(商务卡)',
				'622224'=>'牡丹卡(商务卡)',
				'489734'=>'牡丹欧元卡',
				'489735'=>'牡丹欧元卡',
				'489736'=>'牡丹欧元卡',
				'530970'=>'牡丹万事达信用卡',
				'530990'=>'牡丹万事达信用卡',
				'558360'=>'牡丹万事达信用卡',
				'370249'=>'牡丹运通卡金卡',
				'370246'=>'牡丹运通卡金卡',
				'370248'=>'牡丹运通卡金卡',
				'625330'=>'中国旅游卡',
				'625331'=>'中国旅游卡',
				'625332'=>'中国旅游卡',
				'621558'=>'福农灵通卡',
				'621559'=>'福农灵通卡',
				'625916'=>'港币信用卡',
				'625915'=>'港币信用卡',
				'427010'=>'牡丹VISA卡(单位卡)',
				'427019'=>'牡丹VISA卡(单位卡)',
				'374738'=>'牡丹百夫长信用卡',
				'374739'=>'牡丹百夫长信用卡',
				'544210'=>'牡丹东航联名卡',
				'548943'=>'牡丹东航联名卡',
				'621225'=>'牡丹卡普卡',
				'621226'=>'牡丹卡普卡',
				'6245806'=>'牡丹信用卡',
				'6253098'=>'牡丹信用卡',
				'45806'=>'牡丹信用卡(银联卡)',
				'53098'=>'牡丹信用卡(银联卡)',
				'625939'=>'信用卡',
				'625987'=>'信用卡',
				'622944'=>'CNYEasylinkCard',
				'622949'=>'EliteClubATMCard',
				'625900'=>'ICBC Credit Card',
				'622889'=>'ICBC(Asia) Credit',
				'625019'=>'白金卡',
				'628286'=>'财政预算单位公务卡',
				'622235'=>'贷记卡(个金)',
				'622230'=>'贷记卡(个普)',
				'622245'=>'贷记卡(商金)',
				'622240'=>'贷记卡(商普)',
				'621730'=>'工行东京借记卡',
				'621288'=>'工银财富卡',
				'621731'=>'工银伦敦借记卡',
				'620030'=>'工银亚洲预付卡',
				'621763'=>'工银越南盾借记卡',
				'625934'=>'工银越南盾信用卡',
				'524091'=>'海航信用卡',
				'525498'=>'海航信用卡个人普卡',
				'622236'=>'借贷合一卡',
				'625018'=>'金卡',
				'622208'=>'理财金卡',
				'621227'=>'理财金账户金卡',
				'438126'=>'牡丹VISA白金卡',
				'622206'=>'牡丹卡白金卡',
				'9558'=>'牡丹灵通卡(银联卡)',
				'900010'=>'牡丹宁波市民卡',
				'900000'=>'牡丹社会保障卡',
				'524047'=>'牡丹万事达白金卡',
				'510529'=>'牡丹万事达国际借记卡',
				'370267'=>'牡丹运通白金卡',
				'370247'=>'牡丹运通卡普通卡',
				'625017'=>'普卡',
				'621670'=>'普通高中学生资助卡',
				'621618'=>'武警军人保障卡',
				'620058'=>'银联标准卡',
				'622171'=>'印尼盾复合卡',
				'620516'=>'预付芯片卡',
				'620086'=>'中国旅行卡',
				'628288'=>'中央预算单位公务卡',
				'621281'=>'中职学生资助卡',
				'622246'=>'专用信用消费卡',
				'622215'=>'准贷记卡(个金)',
				'622225'=>'准贷记卡(商金)',
				'622220'=>'准贷记卡(商普)'
			),
			//农业银行
			'103' => array(
				'95595'=>'借记卡(银联卡)',
				'95596'=>'借记卡(银联卡)',
				'95597'=>'借记卡(银联卡)',
				'95598'=>'借记卡(银联卡)',
				'95599'=>'借记卡(银联卡)',
				'622840'=>'金穗通宝卡(银联卡)',
				'622844'=>'金穗通宝卡(银联卡)',
				'622847'=>'金穗通宝卡(银联卡)',
				'622848'=>'金穗通宝卡(银联卡)',
				'622845'=>'金穗通宝卡(银联卡)',
				'622826'=>'复合介质金穗通宝卡',
				'622827'=>'金穗海通卡',
				'622841'=>'金穗惠农卡',
				'103'=>'金穗借记卡',
				'622824'=>'金穗旅游卡(银联卡)',
				'622825'=>'金穗青年卡(银联卡)',
				'622823'=>'金穗社保卡(银联卡)',
				'622846'=>'金穗通宝卡',
				'622843'=>'金穗通宝银卡',
				'622849'=>'金穗通宝钻石卡',
				'622821'=>'金穗校园卡(银联卡)',
				'622822'=>'金穗星座卡(银联卡)',
				'621671'=>'普通高中学生资助卡',
				'620501'=>'市民卡B卡',
				'622828'=>'退役金卡',
				'621619'=>'武警军人保障卡',
				'620059'=>'银联标准卡',
				'623018'=>'掌尚钱包',
				'623206'=>'中国旅游卡',
				'621282'=>'中职学生资助卡',
				'621336'=>'专用惠农卡',
			),
			//中国银行
			'104' => array(
				'621294'=>'借记卡',
				'621293'=>'借记卡',
				'621342'=>'借记卡',
				'621343'=>'借记卡',
				'621394'=>'借记卡',
				'621364'=>'借记卡',
				'621648'=>'借记卡',
				'621248'=>'借记卡',
				'621249'=>'借记卡',
				'621638'=>'借记卡',
				'621334'=>'借记卡',
				'621395'=>'借记卡',
				'524865'=>'长城信用卡',
				'525745'=>'长城信用卡',
				'525746'=>'长城信用卡',
				'524864'=>'长城信用卡',
				'622759'=>'长城信用卡',
				'622761'=>'长城信用卡',
				'622762'=>'长城信用卡',
				'622763'=>'长城信用卡',
				'622752'=>'长城人民币信用卡',
				'622753'=>'长城人民币信用卡',
				'622755'=>'长城人民币信用卡',
				'622757'=>'长城人民币信用卡',
				'622758'=>'长城人民币信用卡',
				'622756'=>'长城人民币信用卡',
				'622754'=>'长城人民币信用卡',
				'512315'=>'中银万事达信用卡',
				'512316'=>'中银万事达信用卡',
				'512411'=>'中银万事达信用卡',
				'512412'=>'中银万事达信用卡',
				'514957'=>'中银万事达信用卡',
				'558868'=>'中银万事达信用卡',
				'514958'=>'中银万事达信用卡',
				'518378'=>'长城万事达信用卡',
				'518379'=>'长城万事达信用卡',
				'518474'=>'长城万事达信用卡',
				'518475'=>'长城万事达信用卡',
				'518476'=>'长城万事达信用卡',
				'547766'=>'长城万事达信用卡',
				'620026'=>'预付卡',
				'620025'=>'预付卡',
				'620531'=>'预付卡',
				'620019'=>'预付卡',
				'620035'=>'预付卡',
				'409672'=>'长城公务卡',
				'552742'=>'长城公务卡',
				'553131'=>'长城公务卡',
				'622771'=>'中银卡',
				'622770'=>'中银卡',
				'622772'=>'中银卡',
				'409668'=>'中银威士信用卡员',
				'409669'=>'中银威士信用卡员',
				'409667'=>'中银威士信用卡员',
				'625141'=>'澳门币贷记卡',
				'625143'=>'澳门币贷记卡',
				'620211'=>'澳门中国银行银联预付卡',
				'620210'=>'澳门中国银行银联预付卡',
				'621661'=>'个人普卡',
				'409666'=>'个人普卡',
				'621787'=>'借记IC个人普卡',
				'621785'=>'借记IC个人普卡',
				'622751'=>'人民币信用卡',
				'622750'=>'人民币信用卡',
				'621756'=>'社保联名借记IC卡',
				'621757'=>'社保联名借记IC卡',
				'621330'=>'社保联名卡',
				'621331'=>'社保联名卡',
				'621758'=>'医保联名借记IC卡',
				'621759'=>'医保联名借记IC卡',
				'621332'=>'医保联名卡',
				'621333'=>'医保联名卡',
				'621663'=>'员工普卡',
				'409665'=>'员工普卡',
				'456351'=>'长城电子借记卡',
				'601382'=>'长城电子借记卡',
				'620202'=>'中国银行银联预付卡',
				'620203'=>'中国银行银联预付卡',
				'625908'=>'中行金融IC卡白金卡',
				'625907'=>'中行金融IC卡白金卡',
				'625909'=>'中行金融IC卡金卡',
				'625906'=>'中行金融IC卡金卡',
				'625910'=>'中行金融IC卡普卡',
				'625905'=>'中行金融IC卡普卡',
				'625040'=>'中银银联双币信用卡',
				'625042'=>'中银银联双币信用卡',
				'622789'=>'BOCCUPPLATINUMCARD',
				'622788'=>'白金卡',
				'622480'=>'财富卡',
				'621212'=>'财互通卡',
				'620514'=>'电子现金卡',
				'409670'=>'个人白金卡',
				'621662'=>'个人金卡',
				'621297'=>'公司借记卡',
				'621741'=>'接触式晶片借记卡',
				'623040'=>'接触式银联双币预制晶片借记卡',
				'621788'=>'借记IC白金卡',
				'621786'=>'借记IC个人金卡',
				'621790'=>'借记IC联名卡',
				'621789'=>'借记IC钻石卡',
				'621215'=>'借记卡普卡',
				'621725'=>'金融IC卡',
				'621666'=>'理财白金卡',
				'621668'=>'理财金卡',
				'621667'=>'理财普卡',
				'621669'=>'理财银卡',
				'621660'=>'联名卡',
				'621672'=>'普通高中学生资助卡',
				'622346'=>'人民币信用卡金卡',
				'625055'=>'商务金卡',
				'558869'=>'世界卡',
				'621231'=>'双币种借记卡',
				'621620'=>'武警军人保障卡',
				'622347'=>'信用卡普通卡',
				'622479'=>'熊猫卡',
				'621256'=>'一卡双账户普卡',
				'622274'=>'银联澳门币卡',
				'628388'=>'银联标准公务卡',
				'620061'=>'银联标准卡',
				'622760'=>'银联单币贷记卡',
				'621041'=>'银联港币借记卡',
				'622273'=>'银联港币卡',
				'377677'=>'银联美运顶级卡',
				'621665'=>'员工金卡',
				'622765'=>'长城单位信用卡金卡',
				'622764'=>'长城单位信用卡普卡',
				'621568'=>'长城福农借记卡金卡',
				'621569'=>'长城福农借记卡普卡',
				'620513'=>'长城宁波市民卡',
				'620040'=>'长城社会保障卡',
				'625140'=>'长城信用卡环球通',
				'628313'=>'长城银联公务IC卡白金卡',
				'628312'=>'长城银联公务IC卡金卡',
				'623208'=>'中国旅游卡',
				'356833'=>'中银JCB卡金卡',
				'356835'=>'中银JCB卡普卡',
				'438088'=>'中银奥运信用卡',
				'622348'=>'中银卡(人民币)',
				'625333'=>'中银旅游信用卡',
				'518377'=>'中银女性主题信用卡',
				'409671'=>'中银威士信用卡',
				'625145'=>'中银银联双币商务卡',
				'621283'=>'中职学生资助卡'
			),
			//建设银行
			'105' => array(
				'5453242'=>'龙卡信用卡',
				'5491031'=>'龙卡信用卡',
				'553242'=>'龙卡信用卡',
				'5544033'=>'龙卡信用卡',
				'524094'=>'乐当家',
				'526410'=>'乐当家',
				'53243'=>'乐当家',
				'436738'=>'龙卡贷记卡',
				'558895'=>'龙卡贷记卡',
				'552801'=>'龙卡贷记卡',
				'622675'=>'银联卡',
				'622676'=>'银联卡',
				'622677'=>'银联卡',
				'621082'=>'建行陆港通龙卡',
				'621083'=>'建行陆港通龙卡',
				'434062'=>'乐当家白金卡',
				'552245'=>'乐当家白金卡',
				'621466'=>'理财白金卡',
				'622966'=>'理财白金卡',
				'621499'=>'理财金卡',
				'622988'=>'理财金卡',
				'628316'=>'龙卡IC公务卡',
				'628317'=>'龙卡IC公务卡',
				'625363'=>'中国旅游卡',
				'625362'=>'中国旅游卡',
				'53242'=>'MASTER准贷记卡',
				'489592'=>'VISA白金信用卡',
				'491031'=>'VISA准贷记金卡',
				'453242'=>'VISA准贷记卡(银联卡)',
				'621488'=>'财富卡私人银行卡',
				'621598'=>'福农卡',
				'621487'=>'借记卡',
				'621081'=>'金融IC卡',
				'589970'=>'金融复合IC卡',
				'621084'=>'扣款卡',
				'434061'=>'乐当家金卡VISA',
				'421349'=>'乐当家银卡VISA',
				'625966'=>'龙卡IC信用卡白金卡',
				'625965'=>'龙卡IC信用卡金卡',
				'625964'=>'龙卡IC信用卡普卡',
				'356899'=>'龙卡JCB白金卡',
				'356896'=>'龙卡JCB金卡',
				'356895'=>'龙卡JCB普卡',
				'436742'=>'龙卡储蓄卡',
				'622700'=>'龙卡储蓄卡(银联卡)',
				'436718'=>'龙卡贷记卡公司卡',
				'531693'=>'龙卡国际白金卡',
				'532458'=>'龙卡国际金卡MASTER',
				'436748'=>'龙卡国际金卡VISA',
				'532450'=>'龙卡国际普通卡MASTER',
				'436745'=>'龙卡国际普通卡VISA',
				'436728'=>'龙卡普通卡VISA',
				'622708'=>'龙卡人民币白金卡',
				'622168'=>'龙卡人民币信用金卡',
				'622166'=>'龙卡人民币信用卡',
				'621700'=>'龙卡通',
				'557080'=>'龙卡万事达白金卡',
				'544887'=>'龙卡万事达金卡',
				'559051'=>'龙卡万事达信用卡',
				'628366'=>'龙卡银联公务卡金卡',
				'628266'=>'龙卡银联公务卡普卡',
				'622725'=>'龙卡准贷记卡',
				'622728'=>'龙卡准贷记卡金卡',
				'622382'=>'人民币卡(银联卡)',
				'622381'=>'人民币信用卡',
				'621467'=>'社保IC卡',
				'621621'=>'武警军人保障卡',
				'620060'=>'银联标准卡',
				'622280'=>'银联储蓄卡',
				'621080'=>'银联理财钻石卡',
				'620107'=>'预付卡',
				'621284'=>'中职学生资助卡',
				'544033'=>'准贷记金卡',
				'622707'=>'准贷记卡',
				'625956'=>'准贷记卡金卡',
				'625955'=>'准贷记卡普卡',
			),
			//交通银行
			'301' => array(
				'458123'=>'太平洋双币贷记卡',
				'458124'=>'太平洋双币贷记卡',
				'520169'=>'太平洋双币贷记卡',
				'552853'=>'太平洋双币贷记卡',
				'521899'=>'太平洋双币贷记卡',
				'955593'=>'太平洋贷记卡(银联卡)',
				'955592'=>'太平洋贷记卡(银联卡)',
				'955591'=>'太平洋贷记卡(银联卡)',
				'955590'=>'太平洋贷记卡(银联卡)',
				'622258'=>'太平洋借记卡',
				'622259'=>'太平洋借记卡',
				'622261'=>'太平洋借记卡',
				'622260'=>'太平洋借记卡',
				'622250'=>'太平洋人民币贷记卡',
				'622251'=>'太平洋人民币贷记卡',
				'622253'=>'太平洋人民币贷记卡',
				'622252'=>'太平洋人民币贷记卡',
				'6653783'=>'太平洋信用卡',
				'49104'=>'太平洋信用卡',
				'53783'=>'太平洋信用卡',
				'6649104'=>'太平洋信用卡',
				'622254'=>'太平洋准贷记卡',
				'622255'=>'太平洋准贷记卡',
				'622256'=>'太平洋准贷记卡',
				'622257'=>'太平洋准贷记卡',
				'625029'=>'双币种信用卡',
				'625028'=>'双币种信用卡',
				'434910'=>'太平洋白金信用卡',
				'522964'=>'太平洋白金信用卡',
				'601428'=>'太平洋万事顺卡',
				'66601428'=>'太平洋万事顺卡',
				'622656'=>'白金卡',
				'620013'=>'港币礼物卡',
				'620021'=>'交行预付卡',
				'621069'=>'交通银行港币借记卡',
				'628218'=>'交通银行公务卡金卡',
				'628216'=>'交通银行公务卡普卡',
				'622262'=>'交银IC卡',
				'620521'=>'世博预付IC卡',
				'621436'=>'双币卡',
				'622284'=>'太平洋MORE卡',
				'66405512'=>'太平洋互连卡',
				'405512'=>'太平洋互连卡(银联卡)',
				'621335'=>'银联借记卡',
				'621002'=>'银联人民币卡',
			),
			//民生银行
			'305' => array(
				'407405'=>'民生贷记卡(银联卡)',
				'421869'=>'民生贷记卡(银联卡)',
				'421870'=>'民生贷记卡(银联卡)',
				'421871'=>'民生贷记卡(银联卡)',
				'512466'=>'民生贷记卡(银联卡)',
				'528948'=>'民生贷记卡(银联卡)',
				'552288'=>'民生贷记卡(银联卡)',
				'517636'=>'民生贷记卡(银联卡)',
				'556610'=>'民生贷记卡(银联卡)',
				'545392'=>'民生MasterCard',
				'545393'=>'民生MasterCard',
				'545431'=>'民生MasterCard',
				'545447'=>'民生MasterCard',
				'622617'=>'民生借记卡(银联卡)',
				'622622'=>'民生借记卡(银联卡)',
				'622615'=>'民生借记卡(银联卡)',
				'622619'=>'民生借记卡(银联卡)',
				'472067'=>'民生国际卡',
				'421393'=>'民生国际卡',
				'472068'=>'民生国际卡',
				'622600'=>'民生信用卡(银联卡)',
				'622601'=>'民生信用卡(银联卡)',
				'628258'=>'公务卡金卡',
				'464580'=>'民VISA无限卡',
				'356858'=>'民生JCB白金卡',
				'356857'=>'民生JCB金卡',
				'356856'=>'民生JCB普卡',
				'356859'=>'民生JCB信用卡',
				'464581'=>'民生VISA商务白金卡',
				'427571'=>'民生国际卡(澳元卡)',
				'427570'=>'民生国际卡(欧元卡)',
				'421865'=>'民生国际卡(银卡)',
				'415599'=>'民生借记卡',
				'553161'=>'民生万事达白金公务卡',
				'545217'=>'民生万事达世界卡',
				'523952'=>'民生万事达钛金卡',
				'622602'=>'民生银联白金信用卡',
				'622621'=>'民生银联个人白金卡',
				'622616'=>'民生银联借记卡－金卡',
				'622603'=>'民生银联商务信用卡',
				'377155'=>'民生运通双币标准信用卡白金卡',
				'377153'=>'民生运通双币信用卡金卡',
				'377152'=>'民生运通双币信用卡普卡',
				'377158'=>'民生运通双币信用卡钻石卡',
				'622620'=>'薪资理财卡',
				'622623'=>'银联标准金卡',
				'625913'=>'银联芯片白金卡',
				'625912'=>'银联芯片金卡',
				'625911'=>'银联芯片普卡',
				'622618'=>'钻石卡',
			),
			//广发银行
			'306' => array(
				'428911'=>'广发信用卡',
				'436768'=>'广发信用卡',
				'436769'=>'广发信用卡',
				'436770'=>'广发信用卡',
				'491032'=>'广发信用卡',
				'491033'=>'广发信用卡',
				'491034'=>'广发信用卡',
				'491035'=>'广发信用卡',
				'491036'=>'广发信用卡',
				'491037'=>'广发信用卡',
				'491038'=>'广发信用卡',
				'436771'=>'广发信用卡',
				'518364'=>'广发信用卡',
				'541709'=>'广发信用卡',
				'541710'=>'广发信用卡',
				'548844'=>'广发信用卡',
				'493427'=>'广发信用卡',
				'520152'=>'广发万事达信用卡',
				'520382'=>'广发万事达信用卡',
				'552794'=>'广发万事达信用卡',
				'528931'=>'广发万事达信用卡',
				'685800'=>'广发万事达信用卡',
				'558894'=>'广发万事达信用卡',
				'406365'=>'广发VISA信用卡',
				'487013'=>'广发VISA信用卡',
				'406366'=>'广发VISA信用卡',
				'6858000'=>'广发理财通',
				'6858001'=>'广发理财通',
				'6858009'=>'广发理财通',
				'625072'=>'银联标准金卡',
				'625809'=>'银联标准金卡',
				'625071'=>'银联标准普卡',
				'625808'=>'银联标准普卡',
				'9111'=>'广发理财通(银联卡)',
				'622568'=>'广发理财通卡',
				'622558'=>'广发银联标准白金卡',
				'622555'=>'广发银联标准金卡',
				'622556'=>'广发银联标准普卡',
				'622557'=>'广发银联标准真情金卡',
				'622559'=>'广发银联标准真情普卡',
				'622560'=>'广发真情白金卡',
				'621462'=>'理财通卡',
				'625810'=>'银联标准白金卡',
				'628260'=>'银联公务金卡',
				'628259'=>'银联公务普卡',
				'625807'=>'银联真情白金卡',
				'625806'=>'银联真情金卡',
				'625805'=>'银联真情普卡',
			),
			//招商银行
			'308' => array(
				'356885'=>'招商银行信用卡',
				'356886'=>'招商银行信用卡',
				'356887'=>'招商银行信用卡',
				'356888'=>'招商银行信用卡',
				'356890'=>'招商银行信用卡',
				'439188'=>'招商银行信用卡',
				'479228'=>'招商银行信用卡',
				'479229'=>'招商银行信用卡',
				'356889'=>'招商银行信用卡',
				'552534'=>'招商银行信用卡',
				'552587'=>'招商银行信用卡',
				'622575'=>'招商银行信用卡',
				'622576'=>'招商银行信用卡',
				'622577'=>'招商银行信用卡',
				'622578'=>'招商银行信用卡',
				'622579'=>'招商银行信用卡',
				'622581'=>'招商银行信用卡',
				'622582'=>'招商银行信用卡',
				'545620'=>'万事达信用卡',
				'545621'=>'万事达信用卡',
				'545947'=>'万事达信用卡',
				'545948'=>'万事达信用卡',
				'545619'=>'万事达信用卡',
				'545623'=>'万事达信用卡',
				'410062'=>'招行国际卡(银联卡)',
				'468203'=>'招行国际卡(银联卡)',
				'512425'=>'招行国际卡(银联卡)',
				'524011'=>'招行国际卡(银联卡)',
				'622580'=>'一卡通(银联卡)',
				'622588'=>'一卡通(银联卡)',
				'95555'=>'一卡通(银联卡)',
				'439225'=>'VISA信用卡',
				'439226'=>'VISA信用卡',
				'625802'=>'芯片IC信用卡',
				'625803'=>'芯片IC信用卡',
				'690755'=>'招行一卡通',
				'690755'=>'招行一卡通',
				'518718'=>'MASTER信用金卡',
				'518710'=>'MASTER信用卡',
				'439227'=>'VISA商务信用卡',
				'620520'=>'电子现金卡',
				'622598'=>'公司卡(银联卡)',
				'622609'=>'金卡',
				'621286'=>'金葵花卡',
				'402658'=>'两地一卡通',
				'370286'=>'美国运通金卡',
				'370285'=>'美国运通绿卡',
				'370289'=>'美国运通商务金卡',
				'370287'=>'美国运通商务绿卡',
				'521302'=>'世纪金花联名信用卡',
				'621299'=>'香港一卡通',
				'621485'=>'银联IC金卡',
				'621483'=>'银联IC普卡',
				'628262'=>'银联标准财政公务卡',
				'628362'=>'银联标准公务卡(金卡)',
				'621486'=>'银联金葵花IC卡',
			),
			//兴业银行
			'309' => array(
				'549633'=>'兴业信用卡',
				'552398'=>'兴业信用卡',
				'548738'=>'兴业信用卡',
				'625087'=>'银联标准贷记金卡',
				'625086'=>'银联标准贷记金卡',
				'625085'=>'银联标准贷记金卡',
				'625082'=>'银联标准贷记普卡',
				'625083'=>'银联标准贷记普卡',
				'625084'=>'银联标准贷记普卡',
				'451290'=>'VISA信用卡(银联卡)',
				'451289'=>'VISA信用卡(银联卡)',
				'524070'=>'万事达信用卡(银联卡)',
				'523036'=>'万事达信用卡(银联卡)',
				'622902'=>'银联信用卡(银联卡)',
				'622901'=>'银联信用卡(银联卡)',
				'461982'=>'VISA标准双币个人普卡',
				'486494'=>'VISA商务金卡',
				'486493'=>'VISA商务普卡',
				'486861'=>'VISA运动白金信用卡',
				'528057'=>'个人白金卡',
				'527414'=>'加菲猫信用卡',
				'90592'=>'兴业卡',
				'622909'=>'兴业卡(银联标准卡)',
				'966666'=>'兴业卡(银联卡)',
				'625962'=>'兴业芯片白金卡',
				'625961'=>'兴业芯片金卡',
				'625960'=>'兴业芯片普卡',
				'625963'=>'兴业芯片钻石卡',
				'438589'=>'兴业智能卡',
				'438588'=>'兴业智能卡(银联卡)',
				'622908'=>'兴业自然人生理财卡',
				'622922'=>'银联白金信用卡',
				'628212'=>'银联标准公务卡',
			),
			//浦发银行
			'310' => array(
				'84301'=>'东方卡',
				'84336'=>'东方卡',
				'622500'=>'东方卡',
				'84373'=>'东方卡',
				'84385'=>'东方卡',
				'84390'=>'东方卡',
				'87000'=>'东方卡',
				'87010'=>'东方卡',
				'87030'=>'东方卡',
				'87040'=>'东方卡',
				'84380'=>'东方卡',
				'984301'=>'东方卡',
				'984303'=>'东方卡',
				'84361'=>'东方卡',
				'87050'=>'东方卡',
				'84342'=>'东方卡',
				'625957'=>'贷记卡',
				'625958'=>'贷记卡',
				'625970'=>'贷记卡',
				'622522'=>'东方卡(银联卡)',
				'622523'=>'东方卡(银联卡)',
				'622521'=>'东方卡(银联卡)',
				'622516'=>'东方轻松理财卡',
				'622518'=>'东方轻松理财卡',
				'622176'=>'浦发单币卡',
				'622177'=>'浦发单币卡',
				'498451'=>'VISA白金信用卡',
				'620530'=>'电子现金卡(IC卡)',
				'622519'=>'东方-标准准贷记卡',
				'621791'=>'东方借记卡(复合卡)',
				'622517'=>'东方-轻松理财卡普卡',
				'622520'=>'东方轻松理财智业金卡',
				'628222'=>'公务卡金卡',
				'628221'=>'公务卡普卡',
				'356852'=>'浦发JCB白金卡',
				'356851'=>'浦发JCB金卡',
				'356850'=>'浦发JCB普卡',
				'622276'=>'浦发联名信用卡',
				'377187'=>'浦发私人银行信用卡',
				'515672'=>'浦发万事达白金卡',
				'517650'=>'浦发万事达金卡',
				'525998'=>'浦发万事达普卡',
				'456418'=>'浦发银行VISA年青卡',
				'622228'=>'浦发银联白金卡',
				'622277'=>'浦发银联单币麦兜普卡',
				'621795'=>'轻松理财白金卡(复合卡)',
				'621793'=>'轻松理财金卡(复合卡)',
				'621352'=>'轻松理财普卡',
				'621792'=>'轻松理财普卡(复合卡)',
				'621390'=>'轻松理财消贷易卡',
				'621796'=>'轻松理财钻石卡(复合卡)',
				'404739'=>'信用卡VISA金卡',
				'404738'=>'信用卡VISA普通',
				'621351'=>'移动联名卡',
				'625971'=>'移动浦发借贷合一联名卡',
				'625993'=>'移动浦发联名卡'
			),
		);
		if(isset($bankAry[$bankCode]) && $bankAry[$bankCode]){
			return $bankAry[$bankCode];
		}
		return array();
	}
	
}