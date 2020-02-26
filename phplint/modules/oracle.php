<?php
/** Oracle functions.

See: {@link http://www.php.net/manual/en/ref.oracle.php}
@deprecated You should use the oci8 extension instead.
@package oracle
*/


# FIXME: dummy values
const ORA_BIND_INOUT = 1,
	ORA_BIND_IN = 1,
	ORA_BIND_OUT = 1,
	ORA_FETCHINTO_ASSOC = 1,
	ORA_FETCHINTO_NULLS = 1;

/*. resource .*/ function ora_logon(/*. string .*/ $user, /*. string .*/ $password){}
/*. resource .*/ function ora_plogon(/*. string .*/ $user, /*. string .*/ $password){}
/*. bool .*/ function ora_logoff(/*. resource .*/ $connection){}
/*. resource .*/ function ora_open(/*. resource .*/ $connection){}
/*. bool .*/ function ora_close(/*. resource .*/ $cursor){}
/*. bool .*/ function ora_commitoff(/*. resource .*/ $connection){}
/*. bool .*/ function ora_commiton(/*. resource .*/ $connection){}
/*. bool .*/ function ora_commit(/*. resource .*/ $connection){}
/*. bool .*/ function ora_rollback(/*. resource .*/ $connection){}
/*. bool .*/ function ora_parse(/*. resource .*/ $cursor, /*. string .*/ $sql_statement /*., args .*/){}
/*. bool .*/ function ora_bind(/*. resource .*/ $cursor, /*. string .*/ $php_variable_name, /*. string .*/ $sql_parameter_name, /*. int .*/ $length /*., args .*/){}
/*. bool .*/ function ora_exec(/*. resource .*/ $cursor){}
/*. int .*/ function ora_numcols(/*. resource .*/ $cursor){}
/*. int .*/ function ora_numrows(/*. resource .*/ $cursor){}
/*. resource .*/ function ora_do(/*. resource .*/ $connection, /*. resource .*/ $cursor){}
/*. bool .*/ function ora_fetch(/*. resource .*/ $cursor){}
/*. int .*/ function ora_fetch_into(/*. resource .*/ $cursor, /*. array .*/ $result /*., args .*/){}
/*. string .*/ function ora_columnname(/*. resource .*/ $cursor, /*. int .*/ $column){}
/*. string .*/ function ora_columntype(/*. resource .*/ $cursor, /*. int .*/ $column){}
/*. int .*/ function ora_columnsize(/*. int .*/ $cursor, /*. int .*/ $column){}
/*. mixed .*/ function ora_getcolumn(/*. resource .*/ $cursor, /*. int .*/ $column){}
/*. string .*/ function ora_error(/*. resource .*/ $cursor_or_connection){}
/*. int .*/ function ora_errorcode(/*. resource .*/ $cursor_or_connection){}
