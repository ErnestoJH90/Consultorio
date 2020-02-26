<?php
/** Process Control Functions.

See: {@link http://www.php.net/manual/en/book.pcntl.php}
@package pcntl
*/


# FIXME: dummy values
const WNOHANG = 1,
	WUNTRACED = 1,
	SIG_IGN = 1,
	SIG_DFL = 1,
	SIG_ERR = 1,
	SIGHUP = 1,
	SIGINT = 1,
	SIGQUIT = 1,
	SIGILL = 1,
	SIGTRAP = 1,
	SIGABRT = 1,
	SIGIOT = 1,
	SIGBUS = 1,
	SIGFPE = 1,
	SIGKILL = 1,
	SIGUSR1 = 1,
	SIGSEGV = 1,
	SIGUSR2 = 1,
	SIGPIPE = 1,
	SIGALRM = 1,
	SIGTERM = 1,
	SIGSTKFLT = 1,
	SIGCLD = 1,
	SIGCHLD = 1,
	SIGCONT = 1,
	SIGSTOP = 1,
	SIGTSTP = 1,
	SIGTTIN = 1,
	SIGTTOU = 1,
	SIGURG = 1,
	SIGXCPU = 1,
	SIGXFSZ = 1,
	SIGVTALRM = 1,
	SIGPROF = 1,
	SIGWINCH = 1,
	SIGPOLL = 1,
	SIGIO = 1,
	SIGPWR = 1,
	SIGSYS = 1,
	SIGBABY = 1,
	PRIO_PGRP = 1,
	PRIO_USER = 1,
	PRIO_PROCESS = 1,
	SIG_BLOCK = 1,
	SIG_UNBLOCK = 1,
	SIG_SETMASK = 1,
	SI_USER = 1,
	SI_NOINFO = 1,
	SI_KERNEL = 1,
	SI_QUEUE = 1,
	SI_TIMER = 1,
	SI_MESGQ = 1,
	SI_ASYNCIO = 1,
	SI_SIGIO = 1,
	SI_TKILL = 1,
	CLD_EXITED = 1,
	CLD_KILLED = 1,
	CLD_DUMPED = 1,
	CLD_TRAPPED = 1,
	CLD_STOPPED = 1,
	CLD_CONTINUED = 1,
	TRAP_BRKPT = 1,
	TRAP_TRACE = 1,
	POLL_IN = 1,
	POLL_OUT = 1,
	POLL_MSG = 1,
	POLL_ERR = 1,
	POLL_PRI = 1,
	POLL_HUP = 1,
	ILL_ILLOPC = 1,
	ILL_ILLOPN = 1,
	ILL_ILLADR = 1,
	ILL_ILLTRP = 1,
	ILL_PRVOPC = 1,
	ILL_PRVREG = 1,
	ILL_COPROC = 1,
	ILL_BADSTK = 1,
	FPE_INTDIV = 1,
	FPE_INTOVF = 1,
	FPE_FLTDIV = 1,
	FPE_FLTOVF = 1,
	FPE_FLTUND = 1,
	FPE_FLTRES = 1,
	FPE_FLTINV = 1,
	FPE_FLTSUB = 1,
	SEGV_MAPERR = 1,
	SEGV_ACCERR = 1,
	BUS_ADRALN = 1,
	BUS_ADRERR = 1,
	BUS_OBJERR = 1;

/*. int    .*/ function pcntl_alarm(/*. int .*/ $seconds){}
/*. string .*/ function pcntl_errno(/*. int .*/ $errno){};
/*. bool   .*/ function pcntl_exec(/*. string .*/ $path /*., args .*/){}
/*. int    .*/ function pcntl_fork(){}
/*. int    .*/ function pcntl_get_last_error(){}
/*. int    .*/ function pcntl_getpriority( /*. args .*/){}
/*. bool   .*/ function pcntl_setpriority(/*. int .*/ $priority /*., args .*/){}
/*. bool   .*/ function pcntl_signal_dispatch(){}
/*. bool   .*/ function pcntl_signal(/*. int .*/ $signo, /*. mixed .*/ $handle, $restart_syscalls = TRUE){}
/*. bool   .*/ function pcntl_sigprocmask(/*. int .*/ $how, /*. int[int] .*/ $set, /*. return int[int] .*/ & $oldset = array()){};
/*. int    .*/ function pcntl_sigtimedwait(/*. int[int] .*/ $set, /*. return mixed[string] .*/ & $siginfo, $seconds = 0, $nanoseconds = 0){}
/*. int    .*/ function pcntl_sigwaitinfo(/*. int[int] .*/ $set, /*. return mixed[string] .*/ & $siginfo){}
/*. string .*/ function pcntl_strerror(/*. int .*/ $errno){};
/*. int    .*/ function pcntl_wait(/*. return int .*/ & $status, $options = 0){}
/*. int    .*/ function pcntl_waitpid(/*. int .*/ $pid, /*. return int .*/ &$status, /*. int .*/ $options = 0){}
/*. int    .*/ function pcntl_wexitstatus(/*. int .*/ $status){}
/*. bool   .*/ function pcntl_wifexited(/*. int .*/ $status){}
/*. bool   .*/ function pcntl_wifsignaled(/*. int .*/ $status){}
/*. bool   .*/ function pcntl_wifstopped(/*. int .*/ $status){}
/*. int    .*/ function pcntl_wstopsig(/*. int .*/ $status){}
/*. int    .*/ function pcntl_wtermsig(/*. int .*/ $status){}
