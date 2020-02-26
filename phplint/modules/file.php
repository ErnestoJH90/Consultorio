<?php

/*
 * File access and logging.
 */

const DEFAULT_INCLUDE_PATH = '.:',
	DIRECTORY_SEPARATOR = '/',
	FILE_APPEND = 8,
	FILE_IGNORE_NEW_LINES = 2,
	FILE_NO_DEFAULT_CONTEXT = 16,
	FILE_SKIP_EMPTY_LINES = 4,
	FILE_USE_INCLUDE_PATH = 1,
	LOCK_EX = 2,
	LOCK_NB = 4,
	LOCK_SH = 1,
	LOCK_UN = 3,
	LOG_ALERT = 1,
	LOG_AUTH = 32,
	LOG_AUTHPRIV = 80,
	LOG_CONS = 2,
	LOG_CRIT = 2,
	LOG_CRON = 72,
	LOG_DAEMON = 24,
	LOG_DEBUG = 7,
	LOG_EMERG = 0,
	LOG_ERR = 3,
	LOG_INFO = 6,
	LOG_KERN = 0,
	LOG_LOCAL0 = 128,
	LOG_LOCAL1 = 136,
	LOG_LOCAL2 = 144,
	LOG_LOCAL3 = 152,
	LOG_LOCAL4 = 160,
	LOG_LOCAL5 = 168,
	LOG_LOCAL6 = 176,
	LOG_LOCAL7 = 184,
	LOG_LPR = 48,
	LOG_MAIL = 16,
	LOG_NDELAY = 8,
	LOG_NEWS = 56,
	LOG_NOTICE = 5,
	LOG_NOWAIT = 16,
	LOG_ODELAY = 4,
	LOG_PERROR = 32,
	LOG_PID = 1,
	LOG_SYSLOG = 40,
	LOG_USER = 8,
	LOG_UUCP = 64,
	LOG_WARNING = 4,
	PATHINFO_BASENAME = 2,
	PATHINFO_DIRNAME = 1,
	PATHINFO_EXTENSION = 4,
	PATH_SEPARATOR = ':',
	SCANDIR_SORT_ASCENDING = 0,
	SCANDIR_SORT_DESCENDING = 1,
	SCANDIR_SORT_NONE = 2,
	SEEK_CUR = 1,
	SEEK_END = 2,
	SEEK_SET = 0;
/*. array .*/ function realpath_cache_get(){}
/*. string.*/ function basename(/*. string .*/ $path, $suffix = ""){}
/*. string.*/ function dirname(/*. string .*/ $path
	/*. if_php_ver_7 .*/ , $levels = 1 /*. end_if_php_ver .*/ ){}
/*. array[string]string .*/ function pathinfo(/*. string .*/ $path /*., args .*/){}
/*. string.*/ function readlink(/*. string .*/ $path){}
/*. int   .*/ function linkinfo(/*. string .*/ $path){}
/*. bool  .*/ function symlink(/*. string .*/ $target, /*. string .*/ $link){}
/*. bool  .*/ function link(/*. string .*/ $target, /*. string .*/ $link){}
/*. bool  .*/ function unlink(/*. string .*/ $filename, /*. resource .*/ $context = NULL)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function readfile(/*. string .*/ $filename, $use_include_path = false, /*. resource .*/ $context = NULL)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function rewind(/*. resource .*/ $handle){}
/*. bool  .*/ function rmdir(/*. string .*/ $dirname, /*. resource .*/ $context = NULL)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function umask($mask = 0){}
/*. bool  .*/ function fclose(/*.resource.*/ $f)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function feof(/*. resource .*/ $f){}
/*. string.*/ function fgetc(/*. resource .*/ $h)
/*. triggers E_WARNING .*/{}
/*. string.*/ function fgets(/*. resource .*/ $f, $length = -1)
/*. triggers E_WARNING .*/{}
/*. string.*/ function fgetss(/*. resource .*/ $f, $length=-1, /*. string .*/ $allowable_tags=NULL)
/*. triggers E_WARNING .*/{}
/*. string.*/ function fread(/*.resource.*/ $f, /*.int.*/ $length)
/*. triggers E_WARNING .*/{}
/*.resource.*/function fopen(/*.string.*/ $filename, /*.string.*/ $mode, $use_include_path = false, /*. resource .*/ $context=NULL)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function fpassthru(/*. resource .*/ $handle)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function ftruncate(/*. resource .*/ $handle, /*. int .*/ $size)
/*. triggers E_WARNING .*/{}
/*. array[string]int .*/ function fstat(/*. resource .*/ $handle)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function fseek(/*. resource .*/ $handle, /*. int .*/ $offset, $whence = SEEK_SET)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function ftell(/*. resource .*/ $handle)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function fflush(/*. resource .*/ $handle)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function fwrite(/*. resource .*/ $handle, /*. string .*/ $s, $length =-1)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function fputs(/*. resource .*/ $handle, /*. string .*/ $s, $length=-1)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function mkdir(/*. string .*/ $pathname, $mode = 0777, $recursive = false, /*. resource .*/ $context=NULL)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function rename(/*. string .*/ $oldname, /*. string .*/ $newname, /*. resource .*/ $context=NULL)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function copy(/*. string .*/ $source, /*. string .*/ $dest, /*. resource .*/ $context=NULL)
/*. triggers E_WARNING .*/{}
/*. string.*/ function tempnam(/*. string .*/ $dir, /*. string .*/ $prefix){}
/*. resource .*/ function tmpfile(){}
/*. array[int]string .*/ function file(/*. string .*/ $filename, $flags=0, /*. resource .*/ $context=NULL)
/*. triggers E_WARNING .*/{}
/*. string.*/ function file_get_contents(/*.string.*/ $fn, $use_include_path = false, /*.resource.*/ $context=NULL, $offset = 0, $maxlen=-1)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function file_put_contents(/*.string.*/ $fn, /*.string.*/ $data, $flags = 0, /*.resource.*/ $context=NULL)
/*. triggers E_WARNING .*/{}
/*. array[int]string .*/ function fgetcsv(/*. resource .*/ $handle, $length = 0, $delimiter = ",", $enclosure = '"', $escape = "\\")
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function flock(/*. resource .*/ $handle, /*. int .*/ $op, /*. return int .*/ &$wouldblock=0)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function set_file_buffer(/*. resource .*/ $stream, /*. int .*/ $buffer){}
/*. string.*/ function realpath(/*. string .*/ $path){}
/*. resource .*/ function opendir(/*. string .*/ $path, /*. resource .*/ $context=NULL)
/*. triggers E_WARNING .*/{}
/*. void  .*/ function closedir(/*. resource .*/ $dirhandle){}
/*. bool  .*/ function chdir(/*. string .*/ $dir)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function chroot(/*. string .*/ $dir)
/*. triggers E_WARNING .*/{}
/*. string.*/ function getcwd()/*. triggers E_WARNING .*/{}
/*. void  .*/ function rewinddir(/*. resource .*/ $dir_handle)
/*. triggers E_WARNING .*/{}
/*. string.*/ function readdir(/*. resource .*/ $dir_handle)
/*. triggers E_WARNING .*/{}

class Directory {
	public /*. string .*/ $path;
	public /*. resource .*/ $handle;
	public /*. string .*/ function read(){}
	public /*. void .*/ function rewind(){}
	public /*. void .*/ function close(){}
}

/*. Directory .*/ function dir(/*. string .*/ $directory, /*. resource .*/ $context=NULL)
/*. triggers E_WARNING .*/{}
/*. array[int]string .*/ function scandir(/*. string .*/ $dir, $sorting_order = SCANDIR_SORT_ASCENDING, /*.resource.*/ $context=NULL)
/*. triggers E_WARNING .*/{}
/*. array[int]string .*/ function glob(/*. string .*/ $pattern, $flags = 0){}
/*. int   .*/ function fileatime(/*. string .*/ $fn)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function filectime(/*. string .*/ $fn)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function filegroup(/*. string .*/ $fn)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function fileinode(/*. string .*/ $fn)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function filemtime(/*. string .*/ $fn)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function fileowner(/*. string .*/ $fn)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function fileperms(/*. string .*/ $fn)
/*. triggers E_WARNING .*/{}
/*. int   .*/ function filesize(/*. string .*/ $filename)
/*. triggers E_WARNING .*/{}
/*. string.*/ function filetype(/*. string .*/ $fn)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function file_exists(/*.string.*/ $fn){}
/*. bool  .*/ function is_writable(/*. string .*/ $fn){}
/*. bool  .*/ function is_writeable(/*. string .*/ $fn){}
/*. bool  .*/ function is_readable(/*. string .*/ $fn){}
/*. bool  .*/ function is_executable(/*. string .*/ $fn){}
/*. bool  .*/ function is_file(/*. string .*/ $fn){}
/*. bool  .*/ function is_dir(/*. string .*/ $fn){}
/*. bool  .*/ function is_link(/*. string .*/ $fn){}
/*. array[]int .*/ function stat(/*. string .*/ $fn)
/*. triggers E_WARNING .*/{}
/*. array[]int .*/ function lstat(/*. string .*/ $fn)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function chown(/*. string .*/ $fn, /*. mixed .*/ $user)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function chgrp(/*. string .*/ $fn, /*. mixed .*/ $group)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function chmod(/*. string .*/ $fn, /*. int .*/ $mode)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function touch(/*. string .*/ $fn, $time = -1, $atime = -1)
/*. triggers E_WARNING .*/{}
/*. void  .*/ function clearstatcache($clear_realpath_cache = false, $filename = ""){}
/*. float .*/ function disk_total_space(/*. string .*/ $dir)
/*. triggers E_WARNING .*/{}
/*. float .*/ function disk_free_space(/*. string .*/ $dir)
/*. triggers E_WARNING .*/{}
/*. float .*/ function diskfreespace(/*. string .*/ $dir)
/*. triggers E_WARNING .*/{}
/*. bool  .*/ function openlog(/*. string .*/ $ident, /*. int .*/ $option, /*. int .*/ $facility){}
/*. bool  .*/ function syslog(/*.int.*/ $priority, /*.string.*/ $msg){}
/*. bool  .*/ function closelog(){}
/*. int   .*/ function fprintf(/*.resource.*/ $f, /*.string.*/ $fmt /*., args .*/){}
/*. int   .*/ function vfprintf(/*. resource .*/ $handle, /*. string .*/ $format, /*. array .*/ $args_){}
/*. mixed .*/ function fscanf(/*. resource .*/ $handle, /*. string .*/ $format /*., args .*/){}
/*. int   .*/ function version_compare(/*. string .*/ $ver1, /*. string .*/ $ver2, $operator=""){}
