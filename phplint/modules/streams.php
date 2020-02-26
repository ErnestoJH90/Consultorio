<?php
/** Stream Functions.

See: {@link http://www.php.net/manual/en/ref.stream.php}
@package streams
*/

/*. require_module 'core'; .*/

# FIXME: in effect, this is part of the "standard" module

const PSFS_ERR_FATAL = 0,
	PSFS_FEED_ME = 1,
	PSFS_FLAG_FLUSH_CLOSE = 2,
	PSFS_FLAG_FLUSH_INC = 1,
	PSFS_FLAG_NORMAL = 0,
	PSFS_PASS_ON = 2,
	STREAM_BUFFER_FULL = 2,
	STREAM_BUFFER_LINE = 1,
	STREAM_BUFFER_NONE = 0,
	STREAM_CAST_AS_STREAM = 0,
	STREAM_CAST_FOR_SELECT = 3,
	STREAM_CLIENT_ASYNC_CONNECT = 2,
	STREAM_CLIENT_CONNECT = 4,
	STREAM_CLIENT_PERSISTENT = 1,
	STREAM_CRYPTO_METHOD_ANY_CLIENT = 63,
	STREAM_CRYPTO_METHOD_ANY_SERVER = 62,
	STREAM_CRYPTO_METHOD_SSLv23_CLIENT = 57,
	STREAM_CRYPTO_METHOD_SSLv23_SERVER = 56,
	STREAM_CRYPTO_METHOD_SSLv2_CLIENT = 3,
	STREAM_CRYPTO_METHOD_SSLv2_SERVER = 2,
	STREAM_CRYPTO_METHOD_SSLv3_CLIENT = 5,
	STREAM_CRYPTO_METHOD_SSLv3_SERVER = 4,
	STREAM_CRYPTO_METHOD_TLS_CLIENT = 9,
	STREAM_CRYPTO_METHOD_TLS_SERVER = 8,
	STREAM_CRYPTO_METHOD_TLSv1_0_CLIENT = 9,
	STREAM_CRYPTO_METHOD_TLSv1_0_SERVER = 8,
	STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT = 17,
	STREAM_CRYPTO_METHOD_TLSv1_1_SERVER = 16,
	STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT = 33,
	STREAM_CRYPTO_METHOD_TLSv1_2_SERVER = 32,
	STREAM_FILTER_ALL = 3,
	STREAM_FILTER_READ = 1,
	STREAM_FILTER_WRITE = 2,
	STREAM_IGNORE_URL = 2,
	STREAM_IPPROTO_ICMP = 1,
	STREAM_IPPROTO_IP = 0,
	STREAM_IPPROTO_RAW = 255,
	STREAM_IPPROTO_TCP = 6,
	STREAM_IPPROTO_UDP = 17,
	STREAM_IS_URL = 1,
	STREAM_META_ACCESS = 6,
	STREAM_META_GROUP = 5,
	STREAM_META_GROUP_NAME = 4,
	STREAM_META_OWNER = 3,
	STREAM_META_OWNER_NAME = 2,
	STREAM_META_TOUCH = 1,
	STREAM_MKDIR_RECURSIVE = 1,
	STREAM_MUST_SEEK = 16,
	STREAM_NOTIFY_AUTH_REQUIRED = 3,
	STREAM_NOTIFY_AUTH_RESULT = 10,
	STREAM_NOTIFY_COMPLETED = 8,
	STREAM_NOTIFY_CONNECT = 2,
	STREAM_NOTIFY_FAILURE = 9,
	STREAM_NOTIFY_FILE_SIZE_IS = 5,
	STREAM_NOTIFY_MIME_TYPE_IS = 4,
	STREAM_NOTIFY_PROGRESS = 7,
	STREAM_NOTIFY_REDIRECTED = 6,
	STREAM_NOTIFY_RESOLVE = 1,
	STREAM_NOTIFY_SEVERITY_ERR = 2,
	STREAM_NOTIFY_SEVERITY_INFO = 0,
	STREAM_NOTIFY_SEVERITY_WARN = 1,
	STREAM_OOB = 1,
	STREAM_OPTION_BLOCKING = 1,
	STREAM_OPTION_READ_BUFFER = 2,
	STREAM_OPTION_READ_TIMEOUT = 4,
	STREAM_OPTION_WRITE_BUFFER = 3,
	STREAM_PEEK = 2,
	STREAM_PF_INET = 2,
	STREAM_PF_INET6 = 10,
	STREAM_PF_UNIX = 1,
	STREAM_REPORT_ERRORS = 8,
	STREAM_SERVER_BIND = 4,
	STREAM_SERVER_LISTEN = 8,
	STREAM_SHUT_RD = 0,
	STREAM_SHUT_RDWR = 2,
	STREAM_SHUT_WR = 1,
	STREAM_SOCK_DGRAM = 2,
	STREAM_SOCK_RAW = 3,
	STREAM_SOCK_RDM = 4,
	STREAM_SOCK_SEQPACKET = 5,
	STREAM_SOCK_STREAM = 1,
	STREAM_URL_STAT_LINK = 1,
	STREAM_URL_STAT_QUIET = 2,
	STREAM_USE_PATH = 1;

/**
 * Bucket used by the {@link php_user_filter} class, but nor really available
 * under PHP, where these objects belong to the generic stdClass. PHPLint needs
 * a specific class in order to allow to access its fields.
 */
class StreamBucket {
	public /*. resource .*/ $bucket;
	public /*. string .*/ $data;
	public /*. int .*/ $datalen = 0;
}

abstract class php_user_filter {
	public /*. string .*/ $filtername;
	public /*. mixed .*/ $params;
	
	/**
	 * @param resource $in
	 * @param resource $out
	 * @param int & $consumed
	 * @param bool $closing
	 * @return int
	 * @triggers E_WARNING
	 */
	public abstract function filter($in, $out, &$consumed, $closing);
	
	public /*. void .*/ function onClose (){}
	public /*. bool .*/ function onCreate (){ return true; }
}


/*. int .*/ function stream_select(/*. array .*/ &$read_streams, /*. array .*/ &$write_streams, /*. array .*/ &$except_streams, /*. int .*/ $tv_sec, $tv_usec = 0){}
/*. resource .*/ function stream_context_create(/*. args .*/){}
/*. bool .*/ function stream_context_set_params(/*. args .*/){}
/*. bool .*/ function stream_context_set_option(/*. resource .*/ $stream /*., args .*/){}
/*. array[string][string] .*/ function stream_context_get_options(
	/*. resource .*/ $stream_or_context){}
/*. bool .*/ function stream_filter_prepend(/*. resource .*/ $stream, /*. string .*/ $filtername /*., args .*/)/*. triggers E_WARNING .*/{}
/*. resource .*/ function stream_filter_append(/*. resource .*/ $stream, /*. string .*/ $filtername /*., args .*/)/*. triggers E_WARNING .*/{}
/*. resource .*/ function stream_socket_client(/*. string .*/ $remoteaddress /*., args .*/){}
/*. resource .*/ function stream_socket_server(/*. string .*/ $localaddress /*., args .*/){}
/*. resource .*/ function stream_socket_accept(/*. resource .*/ $serverstream /*., args .*/){}
/*. string .*/ function stream_socket_get_name(/*. resource .*/ $stream, /*. bool .*/ $want_peer){}
/*. string .*/ function stream_socket_recvfrom(/*. resource .*/ $stream, /*. int .*/ $amount /*., args .*/){}
/*. int .*/ function stream_socket_sendto(/*. resource .*/ $stream, /*. string .*/ $data /*., args .*/){}
/*. int .*/ function stream_copy_to_stream(/*. resource .*/ $source, /*. resource .*/ $dest /*., args .*/){}
/*. string .*/ function stream_get_contents(/*. resource .*/ $source, $maxlength = -1, $offset = -1){}
/*. int   .*/ function stream_set_write_buffer(/*. resource .*/ $stream, /*. int .*/ $buffer){}
/*. bool  .*/ function stream_set_blocking(/*. resource .*/ $stream, /*. boolean .*/ $mode){}
/*. array[string]mixed .*/ function stream_get_meta_data(/*. resource .*/ $stream){}
/*. string.*/ function stream_get_line(/*. resource .*/ $handle, /*. int .*/ $length /*., args .*/){}
/*. bool  .*/ function stream_wrapper_register(/*. string .*/ $protocol, /*. string .*/ $classname)/*. triggers E_WARNING .*/{}
/*. bool  .*/ function stream_register_wrapper(/*. string .*/ $protocol, /*. string .*/ $classname)/*. triggers E_WARNING .*/{}
/*. array[int]string .*/ function stream_get_wrappers(){}
/*. array[int]string .*/ function stream_get_transports(){}
/*. bool  .*/ function stream_set_timeout(/*. resource .*/ $stream, /*. int .*/ $seconds /*., args .*/){}
/*. array .*/ function stream_get_filters(){}
/*. bool .*/ function stream_filter_register(/*. string .*/ $filtername, /*. string .*/ $classname){}
/*. StreamBucket .*/ function stream_bucket_make_writeable(/*. resource .*/ $brigade){}
/*. void .*/ function stream_bucket_prepend(/*. resource .*/ $brigade, /*. StreamBucket .*/ $bucket){}
/*. void .*/ function stream_bucket_append(/*. resource .*/ $brigade, /*. StreamBucket .*/ $bucket){}
/*. resource .*/ function stream_bucket_new(/*. resource .*/ $stream, /*. string .*/ $buffer){}
/*. bool .*/ function stream_socket_shutdown(/*. resource .*/ $stream, /*. int .*/ $how){}

/*. mixed .*/ function stream_socket_enable_crypto(
	/*. resource .*/ $stream,
	/*. bool .*/ $enable,
	/*. int .*/ $crypto_type = 0,
	/*. resource .*/ $session_stream = NULL )
	/*. triggers E_WARNING .*/{}

/*. resource .*/ function stream_context_get_default(
	/*. array[string][string] .*/ $options){}

/*. array[string] .*/ function stream_context_get_params(
	/*. resource .*/ $stream_or_context){}

/*. resource .*/ function stream_context_set_default(
	/*. array[string][string] .*/ $options){}

/*. mixed .*/ function stream_socket_pair(
	/*. int .*/ $domain,
	/*. int .*/ $type,
	/*. int .*/ $protocol){}

/*. bool .*/ function stream_supports_lock(
	/*. resource .*/ $stream){}

/*. bool .*/ function stream_wrapper_restore(
	/*. string .*/ $protocol){}

/*. bool .*/ function stream_wrapper_unregister(
	/*. string .*/ $protocol){}

/*. mixed .*/ function stream_resolve_include_path(
	/*. string .*/ $filename,
	/*. resource .*/ $context = NULL){}
