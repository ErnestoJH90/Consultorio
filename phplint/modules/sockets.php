<?php
/** Socket Functions.

See: {@link http://www.php.net/manual/en/ref.sockets.php}
@package sockets
*/

# Required for E_WARNING:
/*. require_module 'core'; .*/

const AF_INET = 1,
	AF_INET6 = 2,
	AF_UNIX = 3,
	MSG_DONTROUTE = 4,
	MSG_EOF = 5,
	MSG_EOR = 6,
	MSG_OOB = 7,
	MSG_PEEK = 8,
	MSG_WAITALL = 9,
	PHP_BINARY_READ = 10,
	PHP_NORMAL_READ = 11,
	SOCKET_E2BIG = 12,
	SOCKET_EACCES = 13,
	SOCKET_EADDRINUSE = 14,
	SOCKET_EADDRNOTAVAIL = 15,
	SOCKET_EADV = 16,
	SOCKET_EAFNOSUPPORT = 17,
	SOCKET_EAGAIN = 18,
	SOCKET_EALREADY = 19,
	SOCKET_EBADE = 20,
	SOCKET_EBADF = 21,
	SOCKET_EBADFD = 22,
	SOCKET_EBADMSG = 23,
	SOCKET_EBADR = 24,
	SOCKET_EBADRQC = 25,
	SOCKET_EBADSLT = 26,
	SOCKET_EBUSY = 27,
	SOCKET_ECHRNG = 28,
	SOCKET_ECOMM = 29,
	SOCKET_ECONNABORTED = 30,
	SOCKET_ECONNREFUSED = 31,
	SOCKET_ECONNRESET = 32,
	SOCKET_EDESTADDRREQ = 33,
	SOCKET_EDISCON = 34,
	SOCKET_EDQUOT = 35,
	SOCKET_EEXIST = 36,
	SOCKET_EFAULT = 37,
	SOCKET_EHOSTDOWN = 38,
	SOCKET_EHOSTUNREACH = 39,
	SOCKET_EIDRM = 40,
	SOCKET_EINPROGRESS = 41,
	SOCKET_EINTR = 42,
	SOCKET_EINVAL = 43,
	SOCKET_EIO = 44,
	SOCKET_EISCONN = 45,
	SOCKET_EISDIR = 46,
	SOCKET_EISNAM = 47,
	SOCKET_EL2HLT = 48,
	SOCKET_EL2NSYNC = 49,
	SOCKET_EL3HLT = 50,
	SOCKET_EL3RST = 51,
	SOCKET_ELNRNG = 52,
	SOCKET_ELOOP = 53,
	SOCKET_EMEDIUMTYPE = 54,
	SOCKET_EMFILE = 55,
	SOCKET_EMLINK = 56,
	SOCKET_EMSGSIZE = 57,
	SOCKET_EMULTIHOP = 58,
	SOCKET_ENAMETOOLONG = 59,
	SOCKET_ENETDOWN = 60,
	SOCKET_ENETRESET = 61,
	SOCKET_ENETUNREACH = 62,
	SOCKET_ENFILE = 63,
	SOCKET_ENOANO = 64,
	SOCKET_ENOBUFS = 65,
	SOCKET_ENOCSI = 66,
	SOCKET_ENODATA = 67,
	SOCKET_ENODEV = 68,
	SOCKET_ENOENT = 69,
	SOCKET_ENOLCK = 70,
	SOCKET_ENOLINK = 71,
	SOCKET_ENOMEDIUM = 72,
	SOCKET_ENOMEM = 73,
	SOCKET_ENOMSG = 74,
	SOCKET_ENONET = 75,
	SOCKET_ENOPROTOOPT = 76,
	SOCKET_ENOSPC = 77,
	SOCKET_ENOSR = 78,
	SOCKET_ENOSTR = 79,
	SOCKET_ENOSYS = 80,
	SOCKET_ENOTBLK = 81,
	SOCKET_ENOTCONN = 82,
	SOCKET_ENOTDIR = 83,
	SOCKET_ENOTEMPTY = 84,
	SOCKET_ENOTSOCK = 85,
	SOCKET_ENOTTY = 86,
	SOCKET_ENOTUNIQ = 87,
	SOCKET_ENXIO = 88,
	SOCKET_EOPNOTSUPP = 89,
	SOCKET_EPERM = 90,
	SOCKET_EPFNOSUPPORT = 91,
	SOCKET_EPIPE = 92,
	SOCKET_EPROCLIM = 93,
	SOCKET_EPROTO = 94,
	SOCKET_EPROTONOSUPPORT = 95,
	SOCKET_EPROTOTYPE = 96,
	SOCKET_EREMCHG = 97,
	SOCKET_EREMOTE = 98,
	SOCKET_EREMOTEIO = 99,
	SOCKET_ERESTART = 100,
	SOCKET_EROFS = 101,
	SOCKET_ESHUTDOWN = 102,
	SOCKET_ESOCKTNOSUPPORT = 103,
	SOCKET_ESPIPE = 104,
	SOCKET_ESRMNT = 105,
	SOCKET_ESTALE = 106,
	SOCKET_ESTRPIPE = 107,
	SOCKET_ETIME = 108,
	SOCKET_ETIMEDOUT = 109,
	SOCKET_ETOOMANYREFS = 110,
	SOCKET_EUNATCH = 111,
	SOCKET_EUSERS = 112,
	SOCKET_EWOULDBLOCK = 113,
	SOCKET_EXDEV = 114,
	SOCKET_EXFULL = 115,
	SOCKET_HOST_NOT_FOUND = 116,
	SOCKET_NOTINITIALISED = 117,
	SOCKET_NO_ADDRESS = 118,
	SOCKET_NO_DATA = 119,
	SOCKET_NO_RECOVERY = 120,
	SOCKET_SYSNOTREADY = 121,
	SOCKET_TRY_AGAIN = 122,
	SOCKET_VERNOTSUPPORTED = 123,
	SOCK_DGRAM = 124,
	SOCK_RAW = 125,
	SOCK_RDM = 126,
	SOCK_SEQPACKET = 127,
	SOCK_STREAM = 128,
	SOL_SOCKET = 129,
	SOL_TCP = 130,
	SOL_UDP = 131,
	SOMAXCONN = 132,
	SO_BROADCAST = 133,
	SO_DEBUG = 134,
	SO_DONTROUTE = 135,
	SO_ERROR = 136,
	SO_KEEPALIVE = 137,
	SO_LINGER = 138,
	SO_OOBINLINE = 139,
	SO_RCVBUF = 140,
	SO_RCVLOWAT = 141,
	SO_RCVTIMEO = 142,
	SO_REUSEADDR = 143,
	SO_SNDBUF = 144,
	SO_SNDLOWAT = 145,
	SO_SNDTIMEO = 146,
	SO_TYPE = 147;

/*. int .*/ function socket_select(/*. array .*/ &$read_fds, /*. array .*/ &$write_fds, /*. array .*/ &$except_fds, /*. int .*/ $tv_sec /*., args .*/){}
/*. resource .*/ function socket_create_listen(/*. int .*/ $port /*., args .*/){}
/*. resource .*/ function socket_accept(/*. resource .*/ $socket){}
/*. bool .*/ function socket_set_nonblock(/*. resource .*/ $socket){}
/*. bool .*/ function socket_set_block(/*. resource .*/ $socket){}
/*. bool .*/ function socket_listen(/*. resource .*/ $socket /*., args .*/){}
/*. void .*/ function socket_close(/*. resource .*/ $socket){}
/*. int .*/ function socket_write(/*. resource .*/ $socket, /*. string .*/ $buf /*., args .*/){}
/*. string .*/ function socket_read(/*. resource .*/ $socket, /*. int .*/ $length, $type = PHP_BINARY_READ){}
/*. bool .*/ function socket_getsockname(/*. resource .*/ $socket, /*. return string .*/ &$addr /*., args .*/){}
/*. bool .*/ function socket_getpeername(/*. resource .*/ $socket, /*. return string .*/ &$addr /*., args .*/){}
/*. resource .*/ function socket_create(/*. int .*/ $domain, /*. int .*/ $type, /*. int .*/ $protocol)/*. triggers E_WARNING .*/{}
/*. bool .*/ function socket_connect(/*. resource .*/ $socket, /*. string .*/ $addr /*., args .*/){}
/*. string .*/ function socket_strerror(/*. int .*/ $errno){}
/*. bool .*/ function socket_bind(/*. resource .*/ $socket, /*. string .*/ $addr /*., args .*/){}
/*. int .*/ function socket_recv(/*. resource .*/ $socket, /*. string .*/ &$buf, /*. int .*/ $len, /*. int .*/ $flags){}
/*. int .*/ function socket_send(/*. resource .*/ $socket, /*. string .*/ $buf, /*. int .*/ $len, /*. int .*/ $flags){}
/*. int .*/ function socket_recvfrom(/*. resource .*/ $socket, /*. string .*/ &$buf, /*. int .*/ $len, /*. int .*/ $flags, /*. string .*/ &$name /*., args .*/){}
/*. int .*/ function socket_sendto(/*. resource .*/ $socket, /*. string .*/ $buf, /*. int .*/ $len, /*. int .*/ $flags, /*. string .*/ $addr /*., args .*/){}
/*. mixed .*/ function socket_get_option(/*. resource .*/ $socket, /*. int .*/ $level, /*. int .*/ $optname){}
/*. bool .*/ function socket_set_option(/*. args .*/){}
/*. bool .*/ function socket_create_pair(/*. int .*/ $domain, /*. int .*/ $type, /*. int .*/ $protocol, /*. return array .*/ &$fd){}
/*. bool .*/ function socket_shutdown(/*. resource .*/ $socket /*., args .*/){}
/*. int .*/ function socket_last_error( /*. args .*/){}
/*. void .*/ function socket_clear_error( /*. args .*/){}
/*. resource .*/ function socket_export_stream(/*. resource .*/ $socket){}
/*. bool  .*/ function socket_set_blocking(/*. resource .*/ $stream, /*. int .*/ $mode){}
/*. bool  .*/ function socket_set_timeout(/*. resource .*/ $stream, /*. int .*/ $seconds /*., args .*/){}
/*. array[string]mixed .*/ function socket_get_status(/*. resource .*/ $stram){}
