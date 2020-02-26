<?php
/** MCVE Payment Functions.

See: {@link http://www.php.net/manual/en/ref.mcve.php}
@package mcve
*/


# FIXME: dummy values
const MC_TRANTYPE = 1,
	MC_USERNAME = 1,
	MC_PASSWORD = 1,
	MC_ACCOUNT = 1,
	MC_TRACKDATA = 1,
	MC_EXPDATE = 1,
	MC_STREET = 1,
	MC_ZIP = 1,
	MC_CV = 1,
	MC_COMMENTS = 1,
	MC_CLERKID = 1,
	MC_STATIONID = 1,
	MC_APPRCODE = 1,
	MC_AMOUNT = 1,
	MC_PTRANNUM = 1,
	MC_TTID = 1,
	MC_USER = 1,
	MC_PWD = 1,
	MC_ACCT = 1,
	MC_BDATE = 1,
	MC_EDATE = 1,
	MC_BATCH = 1,
	MC_FILE = 1,
	MC_ADMIN = 1,
	MC_AUDITTYPE = 1,
	MC_CUSTOM = 1,
	MC_EXAMOUNT = 1,
	MC_EXCHARGES = 1,
	MC_RATE = 1,
	MC_RENTERNAME = 1,
	MC_RETURNCITY = 1,
	MC_RETURNSTATE = 1,
	MC_RETURNLOCATION = 1,
	MC_PRIORITY = 1,
	MC_INQUIRY = 1,
	MC_CARDTYPES = 1,
	MC_SUB = 1,
	MC_MARKER = 1,
	MC_DEVICETYPE = 1,
	MC_ERRORCODE = 1,
	MC_NEWBATCH = 1,
	MC_CURR = 1,
	MC_DESCMERCH = 1,
	MC_DESCLOC = 1,
	MC_ORIGTYPE = 1,
	MC_PIN = 1,
	MC_VOIDORIGTYPE = 1,
	MC_TIMESTAMP = 1,
	MC_PRIO_HIGH = 1,
	MC_PRIO_NORMAL = 1,
	MC_PRIO_LOW = 1,
	MC_USER_PROC = 1,
	MC_USER_USER = 1,
	MC_USER_PWD = 1,
	MC_USER_INDCODE = 1,
	MC_USER_MERCHID = 1,
	MC_USER_BANKID = 1,
	MC_USER_TERMID = 1,
	MC_USER_CLIENTNUM = 1,
	MC_USER_STOREID = 1,
	MC_USER_AGENTID = 1,
	MC_USER_CHAINID = 1,
	MC_USER_ZIPCODE = 1,
	MC_USER_TIMEZONE = 1,
	MC_USER_MERCHCAT = 1,
	MC_USER_MERNAME = 1,
	MC_USER_MERCHLOC = 1,
	MC_USER_STATECODE = 1,
	MC_USER_PHONE = 1,
	MC_USER_SUB = 1,
	MC_USER_CARDTYPES = 1,
	MC_USER_MODE = 1,
	MC_USER_VNUMBER = 1,
	MC_USER_ROUTINGID = 1,
	MC_USER_PPROPERTY = 1,
	MC_USER_PID = 1,
	MC_USER_PIDPWD = 1,
	MC_USER_SMID = 1,
	MC_USER_SMIDPWD = 1,
	MC_USER_USDDIV = 1,
	MC_USER_AUDDIV = 1,
	MC_USER_DKKDIV = 1,
	MC_USER_GBPDIV = 1,
	MC_USER_HKDDIV = 1,
	MC_USER_JPYDIV = 1,
	MC_USER_NZDDIV = 1,
	MC_USER_NOKDIV = 1,
	MC_USER_SGDDIV = 1,
	MC_USER_ZARDIV = 1,
	MC_USER_SEKDIV = 1,
	MC_USER_CHFDIV = 1,
	MC_USER_CADDIV = 1,
	MC_USER_DIVNUM = 1,
	MC_CARD_VISA = 1,
	MC_CARD_MC = 1,
	MC_CARD_AMEX = 1,
	MC_CARD_DISC = 1,
	MC_CARD_JCB = 1,
	MC_CARD_CB = 1,
	MC_CARD_DC = 1,
	MC_CARD_GIFT = 1,
	MC_CARD_OTHER = 1,
	MC_CARD_ALL = 1,
	MC_MODE_AUTH = 1,
	MC_MODE_SETTLE = 1,
	MC_MODE_BOTH = 1,
	MC_MODE_ALL = 1,
	MC_EXCHARGES_REST = 1,
	MC_EXCHARGES_GIFT = 1,
	MC_EXCHARGES_MINI = 1,
	MC_EXCHARGES_TELE = 1,
	MC_EXCHARGES_OTHER = 1,
	MC_EXCHARGES_LAUND = 1,
	MC_EXCHARGES_NONE = 1,
	MC_EXCHARGES_GAS = 1,
	MC_EXCHARGES_MILE = 1,
	MC_EXCHARGES_LATE = 1,
	MC_EXCHARGES_1WAY = 1,
	MC_EXCHARGES_VIOL = 1,
	MC_TRAN_SALE = 1,
	MC_TRAN_REDEMPTION = 1,
	MC_TRAN_PREAUTH = 1,
	MC_TRAN_VOID = 1,
	MC_TRAN_PREAUTHCOMPLETE = 1,
	MC_TRAN_FORCE = 1,
	MC_TRAN_OVERRIDE = 1,
	MC_TRAN_RETURN = 1,
	MC_TRAN_RELOAD = 1,
	MC_TRAN_CREDIT = 1,
	MC_TRAN_SETTLE = 1,
	MC_TRAN_INCREMENTAL = 1,
	MC_TRAN_REVERSAL = 1,
	MC_TRAN_ACTIVATE = 1,
	MC_TRAN_BALANCEINQ = 1,
	MC_TRAN_CASHOUT = 1,
	MC_TRAN_TOREVERSAL = 1,
	MC_TRAN_SETTLERFR = 1,
	MC_TRAN_ISSUE = 1,
	MC_TRAN_TIP = 1,
	MC_TRAN_MERCHRETURN = 1,
	MC_TRAN_IVRREQ = 1,
	MC_TRAN_IVRRESP = 1,
	MC_TRAN_ADMIN = 1,
	MC_TRAN_PING = 1,
	MC_TRAN_CHKPWD = 1,
	MC_TRAN_CHNGPWD = 1,
	MC_TRAN_LISTSTATS = 1,
	MC_TRAN_LISTUSERS = 1,
	MC_TRAN_GETUSERINFO = 1,
	MC_TRAN_ADDUSER = 1,
	MC_TRAN_EDITUSER = 1,
	MC_TRAN_DELUSER = 1,
	MC_TRAN_ENABLEUSER = 1,
	MC_TRAN_DISABLEUSER = 1,
	MC_TRAN_IMPORT = 1,
	MC_TRAN_EXPORT = 1,
	MC_TRAN_ERRORLOG = 1,
	MC_TRAN_CLEARERRORLOG = 1,
	MC_TRAN_GETSUBACCTS = 1,
	MC_ADMIN_GUT = 1,
	MC_ADMIN_GL = 1,
	MC_ADMIN_GFT = 1,
	MC_ADMIN_BT = 1,
	MC_ADMIN_UB = 1,
	MC_ADMIN_QC = 1,
	MC_ADMIN_RS = 1,
	MC_ADMIN_CTH = 1,
	MC_ADMIN_CFH = 1,
	MC_ADMIN_FORCESETTLE = 1,
	MC_ADMIN_SETBATCHNUM = 1,
	MC_ADMIN_RENUMBERBATCH = 1,
	MC_ADMIN_FIELDEDIT = 1,
	MC_ADMIN_CLOSEBATCH = 1,
	M_UNUSED = 1,
	M_NEW = 1,
	M_PENDING = 1,
	M_DONE = 1,
	M_GOOD = 1,
	M_BAD = 1,
	M_STREET = 1,
	M_ZIP = 1,
	M_UNKNOWN = 1,
	M_ERROR = 1,
	M_FAIL = 1,
	M_SUCCESS = 1,
	M_AUTH = 1,
	M_DENY = 1,
	M_CALL = 1,
	M_DUPL = 1,
	M_PKUP = 1,
	M_RETRY = 1,
	M_SETUP = 1,
	M_TIMEOUT = 1,
	M_SALE = 1,
	M_PREAUTH = 1,
	M_FORCE = 1,
	M_OVERRIDE = 1,
	M_RETURN = 1,
	M_SETTLE = 1,
	M_PROC = 1,
	M_USER = 1,
	M_PWD = 1,
	M_INDCODE = 1,
	M_MERCHID = 1,
	M_BANKID = 1,
	M_TERMID = 1,
	M_CLIENTNUM = 1,
	M_STOREID = 1,
	M_AGENTID = 1,
	M_CHAINID = 1,
	M_ZIPCODE = 1,
	M_TIMEZONE = 1,
	M_MERCHCAT = 1,
	M_MERNAME = 1,
	M_MERCHLOC = 1,
	M_STATECODE = 1,
	M_SERVICEPHONE = 1,
	MCVE_UNUSED = 1,
	MCVE_NEW = 1,
	MCVE_PENDING = 1,
	MCVE_DONE = 1,
	MCVE_GOOD = 1,
	MCVE_BAD = 1,
	MCVE_STREET = 1,
	MCVE_ZIP = 1,
	MCVE_UNKNOWN = 1,
	MCVE_ERROR = 1,
	MCVE_FAIL = 1,
	MCVE_SUCCESS = 1,
	MCVE_AUTH = 1,
	MCVE_DENY = 1,
	MCVE_CALL = 1,
	MCVE_DUPL = 1,
	MCVE_PKUP = 1,
	MCVE_RETRY = 1,
	MCVE_SETUP = 1,
	MCVE_TIMEOUT = 1,
	MCVE_SALE = 1,
	MCVE_PREAUTH = 1,
	MCVE_FORCE = 1,
	MCVE_OVERRIDE = 1,
	MCVE_RETURN = 1,
	MCVE_SETTLE = 1,
	MCVE_PROC = 1,
	MCVE_USER = 1,
	MCVE_PWD = 1,
	MCVE_INDCODE = 1,
	MCVE_MERCHID = 1,
	MCVE_BANKID = 1,
	MCVE_TERMID = 1,
	MCVE_CLIENTNUM = 1,
	MCVE_STOREID = 1,
	MCVE_AGENTID = 1,
	MCVE_CHAINID = 1,
	MCVE_ZIPCODE = 1,
	MCVE_TIMEZONE = 1,
	MCVE_MERCHCAT = 1,
	MCVE_MERNAME = 1,
	MCVE_MERCHLOC = 1,
	MCVE_STATECODE = 1,
	MCVE_SERVICEPHONE = 1;

/*. int .*/ function m_initengine(/*. string .*/ $location){}
/*. resource .*/ function m_initconn(){}
/*. bool .*/ function m_deleteresponse(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. bool .*/ function m_deletetrans(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. void .*/ function m_destroyconn(/*. resource .*/ $conn){}
/*. int .*/ function m_setdropfile(/*. resource .*/ $conn, /*. string .*/ $directory){}
/*. int .*/ function m_setip(/*. resource .*/ $conn, /*. string .*/ $host, /*. int .*/ $port){}
/*. int .*/ function m_setssl(/*. resource .*/ $conn, /*. string .*/ $host, /*. int .*/ $port){}
/*. int .*/ function m_setssl_files(/*. resource .*/ $conn, /*. string .*/ $sslkeyfile, /*. string .*/ $sslcertfile){}
/*. int .*/ function m_settimeout(/*. resource .*/ $conn, /*. int .*/ $seconds){}
/*. int .*/ function m_setblocking(/*. resource .*/ $conn, /*. int .*/ $tf){}
/*. bool .*/ function m_verifyconnection(/*. resource .*/ $conn, /*. int .*/ $tf){}
/*. bool .*/ function m_verifysslcert(/*. resource .*/ $conn, /*. int .*/ $tf){}
/*. bool .*/ function m_maxconntimeout(/*. resource .*/ $conn, /*. int .*/ $secs){}
/*. int .*/ function m_connect(/*. resource .*/ $conn){}
/*. string .*/ function m_connectionerror(/*. resource .*/ $conn){}
/*. int .*/ function m_transactionssent(/*. resource .*/ $conn){}
/*. int .*/ function m_ping(/*. resource .*/ $conn){}
/*. int .*/ function m_transnew(/*. resource .*/ $conn){}
/*. int .*/ function m_transsend(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. string .*/ function m_responseparam(/*. resource .*/ $conn, /*. int .*/ $identifier, /*. string .*/ $key){}
/*. string .*/ function m_getuserparam(/*. resource .*/ $conn, /*. int .*/ $identifier, /*. int .*/ $key){}
/*. int .*/ function m_returnstatus(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. int .*/ function m_returncode(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. int .*/ function m_transactionitem(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. int .*/ function m_transactionavs(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. int .*/ function m_transactioncv(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. int .*/ function m_transactionbatch(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. int .*/ function m_transactionid(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. string .*/ function m_transactionauth(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. string .*/ function m_transactiontext(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. int .*/ function m_monitor(/*. resource .*/ $conn){}
/*. int .*/ function m_transinqueue(/*. resource .*/ $conn){}
/*. int .*/ function m_checkstatus(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. int .*/ function m_completeauthorizations(/*. resource .*/ $conn, /*. int .*/ &$array_){}
/*. int .*/ function m_sale(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password, /*. string .*/ $trackdata, /*. string .*/ $account, /*. string .*/ $expdate, /*. float .*/ $amount, /*. string .*/ $street, /*. string .*/ $zip, /*. string .*/ $cv, /*. string .*/ $comments, /*. string .*/ $clerkid, /*. string .*/ $stationid, /*. int .*/ $ptrannum){}
/*. int .*/ function m_preauth(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password, /*. string .*/ $trackdata, /*. string .*/ $account, /*. string .*/ $expdate, /*. float .*/ $amount, /*. string .*/ $street, /*. string .*/ $zip, /*. string .*/ $cv, /*. string .*/ $comments,	/*. string .*/ $clerkid, /*. string .*/ $stationid, /*. int .*/ $ptrannum){}
/*. int .*/ function m_override(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password, /*. string .*/ $trackdata, /*. string .*/ $account, /*. string .*/ $expdate, /*. float .*/ $amount, /*. string .*/ $street, /*. string .*/ $zip, /*. string .*/ $cv, /*. string .*/ $comments, /*. string .*/ $clerkid, /*. string .*/ $stationid, /*. int .*/ $ptrannum){}
/*. int .*/ function m_void(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password, /*. int .*/ $sid, /*. int .*/ $ptrannum){}
/*. int .*/ function m_preauthcompletion(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password, /*. float .*/ $finalamount, /*. int .*/ $sid, /*. int .*/ $ptrannum){}
/*. int .*/ function m_force(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password, /*. string .*/ $trackdata, /*. string .*/ $account, /*. string .*/ $expdate, /*. float .*/ $amount, /*. string .*/ $authcode, /*. string .*/ $comments, /*. string .*/ $clerkid, /*. string .*/ $stationid, /*. int .*/ $ptrannum){}
/*. int .*/ function m_return(/*. int .*/ $conn, /*. string .*/ $username, /*. string .*/ $password, /*. string .*/ $trackdata, /*. string .*/ $account, /*. string .*/ $expdate, /*. float .*/ $amount, /*. string .*/ $comments, /*. string .*/ $clerkid, /*. string .*/ $stationid, /*. int .*/ $ptrannum){}
/*. int .*/ function m_settle(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password, /*. string .*/ $batch){}
/*. int .*/ function m_ub(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password){}
/*. int .*/ function m_qc(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password, /*. string .*/ $clerkid, /*. string .*/ $stationid, /*. string .*/ $comments, /*. int .*/ $ptrannum){}
/*. int .*/ function m_gut(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password, /*. int .*/ $type, /*. string .*/ $account, /*. string .*/ $clerkid, /*. string .*/ $stationid, /*. string .*/ $comments, /*. int .*/ $ptrannum, /*. string .*/ $startdate, /*. string .*/ $enddate){}
/*. int .*/ function m_gl(/*. int .*/ $conn, /*. string .*/ $username, /*. string .*/ $password, /*. int .*/ $type, /*. string .*/ $account, /*. string .*/ $batch, /*. string .*/ $clerkid, /*. string .*/ $stationid, /*. string .*/ $comments, /*. int .*/ $ptrannum, /*. string .*/ $startdate, /*. string .*/ $enddate){}
/*. int .*/ function m_gft(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password, /*. int .*/ $type, /*. string .*/ $account, /*. string .*/ $clerkid, /*. string .*/ $stationid, /*. string .*/ $comments, /*. int .*/ $ptrannum, /*. string .*/ $startdate, /*. string .*/ $enddate){}
/*. int .*/ function m_chkpwd(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password){}
/*. int .*/ function m_bt(/*. resource .*/ $conn, /*. string .*/ $username, /*. string .*/ $password){}
/*. string .*/ function m_getcell(/*. resource .*/ $conn, /*. int .*/ $identifier, /*. string .*/ $column, /*. int .*/ $row){}
/*. string .*/ function m_getcellbynum(/*. resource .*/ $conn, /*. int .*/ $identifier, /*. int .*/ $column, /*. int .*/ $row){}
/*. int .*/ function m_numcolumns(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. int .*/ function m_numrows(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. int .*/ function m_iscommadelimited(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. int .*/ function m_parsecommadelimited(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. string .*/ function m_getcommadelimited(/*. resource .*/ $conn, /*. int .*/ $identifier){}
/*. string .*/ function m_getheader(/*. resource .*/ $conn, /*. int .*/ $identifier, /*. int .*/ $column_num){}
/*. void .*/ function m_destroyengine(){}
/*. int .*/ function m_chngpwd(/*. resource .*/ $conn, /*. string .*/ $admin_password, /*. string .*/ $new_password){}
/*. int .*/ function m_listusers(/*. resource .*/ $conn, /*. string .*/ $admin_password){}
/*. int .*/ function m_enableuser(/*. resource .*/ $conn, /*. string .*/ $admin_password, /*. string .*/ $username){}
/*. int .*/ function m_disableuser(/*. resource .*/ $conn, /*. string .*/ $admin_password, /*. string .*/ $username){}
/*. int .*/ function m_deluser(/*. resource .*/ $conn, /*. string .*/ $admin_password, /*. string .*/ $username){}
/*. int .*/ function m_liststats(/*. resource .*/ $conn, /*. string .*/ $admin_password){}
/*. resource .*/ function m_initusersetup(){}
/*. void .*/ function m_deleteusersetup(/*. resource .*/ $usersetup){}
/*. int .*/ function m_adduserarg(/*. resource .*/ $usersetup, /*. int .*/ $argtype, /*. string .*/ $argval){}
/*. string .*/ function m_getuserarg(/*. resource .*/ $usersetup, /*. int .*/ $argtype){}
/*. int .*/ function m_adduser(/*. resource .*/ $conn, /*. string .*/ $admin_password, /*. int .*/ $usersetup){}
/*. int .*/ function m_edituser(/*. resource .*/ $conn, /*. string .*/ $admin_password, /*. int .*/ $usersetup){}
/*. int .*/ function m_uwait(/*. int .*/ $microsecs){}
/*. string .*/ function m_text_code(/*. string .*/ $code){}
/*. string .*/ function m_text_avs(/*. string .*/ $code){}
/*. string .*/ function m_text_cv(/*. int .*/ $code){}
