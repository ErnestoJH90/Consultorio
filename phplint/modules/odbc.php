<?php
/** ODBC Functions (Unified).

See: {@link http://www.php.net/manual/en/ref.uodbc.php}
@package odbc
*/


# FIXME: dummy values
const ODBC_BINMODE_PASSTHRU = 1,
	ODBC_BINMODE_RETURN = 1,
	ODBC_BINMODE_CONVERT = 1,
	SQL_ODBC_CURSORS = 1,
	SQL_CUR_USE_DRIVER = 1,
	SQL_CUR_USE_IF_NEEDED = 1,
	SQL_CUR_USE_ODBC = 1,
	SQL_CONCURRENCY = 1,
	SQL_CONCUR_READ_ONLY = 1,
	SQL_CONCUR_LOCK = 1,
	SQL_CONCUR_ROWVER = 1,
	SQL_CONCUR_VALUES = 1,
	SQL_CURSOR_TYPE = 1,
	SQL_CURSOR_FORWARD_ONLY = 1,
	SQL_CURSOR_KEYSET_DRIVEN = 1,
	SQL_CURSOR_DYNAMIC = 1,
	SQL_CURSOR_STATIC = 1,
	SQL_KEYSET_SIZE = 1,
	SQL_FETCH_FIRST = 1,
	SQL_FETCH_NEXT = 1,
	SQL_CHAR = 1,
	SQL_VARCHAR = 1,
	SQL_LONGVARCHAR = 1,
	SQL_DECIMAL = 1,
	SQL_NUMERIC = 1,
	SQL_BIT = 1,
	SQL_TINYINT = 1,
	SQL_SMALLINT = 1,
	SQL_INTEGER = 1,
	SQL_BIGINT = 1,
	SQL_REAL = 1,
	SQL_FLOAT = 1,
	SQL_DOUBLE = 1,
	SQL_BINARY = 1,
	SQL_VARBINARY = 1,
	SQL_LONGVARBINARY = 1,
	SQL_DATE = 1,
	SQL_TIME = 1,
	SQL_TIMESTAMP = 1,
	SQL_TYPE_DATE = 1,
	SQL_TYPE_TIME = 1,
	SQL_TYPE_TIMESTAMP = 1,
	SQL_BEST_ROWID = 1,
	SQL_ROWVER = 1,
	SQL_SCOPE_CURROW = 1,
	SQL_SCOPE_TRANSACTION = 1,
	SQL_SCOPE_SESSION = 1,
	SQL_NO_NULLS = 1,
	SQL_NULLABLE = 1,
	SQL_INDEX_UNIQUE = 1,
	SQL_INDEX_ALL = 1,
	SQL_ENSURE = 1,
	SQL_QUICK = 1,
	ODBC_TYPE = '?';

/*. int .*/ function birdstep_connect(/*. string .*/ $server, /*. string .*/ $user, /*. string .*/ $pass){}
/*. bool .*/ function birdstep_close(/*. int .*/ $id){}
/*. int .*/ function birdstep_exec(/*. int .*/ $index, /*. string .*/ $exec_str){}
/*. bool .*/ function birdstep_fetch(/*. int .*/ $index){}
/*. mixed .*/ function birdstep_result(/*. int .*/ $index, /*. int .*/ $col){}
/*. bool .*/ function birdstep_freeresult(/*. int .*/ $index){}
/*. bool .*/ function birdstep_autocommit(/*. int .*/ $index){}
/*. bool .*/ function birdstep_off_autocommit(/*. int .*/ $index){}
/*. bool .*/ function birdstep_commit(/*. int .*/ $index){}
/*. bool .*/ function birdstep_rollback(/*. int .*/ $index){}
/*. string .*/ function birdstep_fieldname(/*. int .*/ $index, /*. int .*/ $col){}
/*. int .*/ function birdstep_fieldnum(/*. int .*/ $index){}
/*. void .*/ function odbc_close_all(){}
/*. bool .*/ function odbc_binmode(/*. int .*/ $result_id, /*. int .*/ $mode){}
/*. bool .*/ function odbc_longreadlen(/*. int .*/ $result_id, /*. int .*/ $length){}
/*. resource .*/ function odbc_prepare(/*. resource .*/ $connection_id, /*. string .*/ $query){}
/*. bool .*/ function odbc_execute(/*. resource .*/ $result_id /*., args .*/){}
/*. string .*/ function odbc_cursor(/*. resource .*/ $result_id){}
/*. array .*/ function odbc_data_source(/*. resource .*/ $connection_id, /*. int .*/ $fetch_type){}
/*. resource .*/ function odbc_exec(/*. resource .*/ $connection_id, /*. string .*/ $query /*., args .*/){}
/*. object .*/ function odbc_fetch_object(/*. int .*/ $result /*., args .*/){}
/*. array .*/ function odbc_fetch_array(/*. int .*/ $result /*., args .*/){}
/*. int .*/ function odbc_fetch_into(/*. resource .*/ $result_id, /*. array .*/ $result_array /*., args .*/){}
/*. bool .*/ function solid_fetch_prev(/*. resource .*/ $result_id){}
/*. bool .*/ function odbc_fetch_row(/*. resource .*/ $result_id /*., args .*/){}
/*. mixed .*/ function odbc_result(/*. resource .*/ $result_id, /*. mixed .*/ $field){}
/*. int .*/ function odbc_result_all(/*. resource .*/ $result_id /*., args .*/){}
/*. bool .*/ function odbc_free_result(/*. resource .*/ $result_id){}
/*. resource .*/ function odbc_connect(/*. string .*/ $DSN, /*. string .*/ $user, /*. string .*/ $password /*., args .*/){}
/*. resource .*/ function odbc_pconnect(/*. string .*/ $DSN, /*. string .*/ $user, /*. string .*/ $password /*., args .*/){}
/*. void .*/ function odbc_close(/*. resource .*/ $connection_id){}
/*. int .*/ function odbc_num_rows(/*. resource .*/ $result_id){}
/*. bool .*/ function odbc_next_result(/*. resource .*/ $result_id){}
/*. int .*/ function odbc_num_fields(/*. resource .*/ $result_id){}
/*. string .*/ function odbc_field_name(/*. resource .*/ $result_id, /*. int .*/ $field_number){}
/*. string .*/ function odbc_field_type(/*. resource .*/ $result_id, /*. int .*/ $field_number){}
/*. int .*/ function odbc_field_len(/*. resource .*/ $result_id, /*. int .*/ $field_number){}
/*. int .*/ function odbc_field_scale(/*. resource .*/ $result_id, /*. int .*/ $field_number){}
/*. int .*/ function odbc_field_num(/*. resource .*/ $result_id, /*. string .*/ $field_name){}
/*. mixed .*/ function odbc_autocommit(/*. resource .*/ $connection_id /*., args .*/){}
/*. bool .*/ function odbc_commit(/*. resource .*/ $connection_id){}
/*. bool .*/ function odbc_rollback(/*. resource .*/ $connection_id){}
/*. string .*/ function odbc_error( /*. args .*/){}
/*. string .*/ function odbc_errormsg( /*. args .*/){}
/*. bool .*/ function odbc_setoption(/*. args .*/){}
/*. resource .*/ function odbc_tables(/*. resource .*/ $connection_id /*., args .*/){}
/*. resource .*/ function odbc_columns(/*. resource .*/ $connection_id /*., args .*/){}
/*. resource .*/ function odbc_columnprivileges(/*. resource .*/ $connection_id, /*. string .*/ $catalog, /*. string .*/ $schema, /*. string .*/ $table, /*. string .*/ $column){}
/*. resource .*/ function odbc_foreignkeys(/*. resource .*/ $connection_id, /*. string .*/ $pk_qualifier, /*. string .*/ $pk_owner, /*. string .*/ $pk_table, /*. string .*/ $fk_qualifier, /*. string .*/ $fk_owner, /*. string .*/ $fk_table){}
/*. resource .*/ function odbc_gettypeinfo(/*. resource .*/ $connection_id /*., args .*/){}
/*. resource .*/ function odbc_primarykeys(/*. resource .*/ $connection_id, /*. string .*/ $qualifier, /*. string .*/ $owner, /*. string .*/ $table){}
/*. resource .*/ function odbc_procedurecolumns(/*. resource .*/ $connection_id /*., args .*/){}
/*. resource .*/ function odbc_procedures(/*. resource .*/ $connection_id /*., args .*/){}
/*. resource .*/ function odbc_specialcolumns(/*. resource .*/ $connection_id, /*. int .*/ $type, /*. string .*/ $qualifier, /*. string .*/ $owner, /*. string .*/ $table, /*. int .*/ $scope, /*. int .*/ $nullable){}
/*. resource .*/ function odbc_statistics(/*. resource .*/ $connection_id, /*. string .*/ $qualifier, /*. string .*/ $owner, /*. string .*/ $name, /*. int .*/ $unique, /*. int .*/ $accuracy){}
/*. resource .*/ function odbc_tableprivileges(/*. resource .*/ $connection_id, /*. string .*/ $qualifier, /*. string .*/ $owner, /*. string .*/ $name){}
