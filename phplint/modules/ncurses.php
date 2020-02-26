<?php
/** Ncurses Terminal Screen Control Functions.

This module now available from PECL.
See: {@link http://www.php.net/manual/en/ref.ncurses.php}
@package ncurses
*/


# FIXME: dummy values
const NCURSES_ = 1,
	NCURSES_KEY_F = 1;

/*. int .*/ function ncurses_addch(/*. int .*/ $ch){}
/*. int .*/ function ncurses_waddch(/*. resource .*/ $window, /*. int .*/ $ch){}
/*. int .*/ function ncurses_color_set(/*. int .*/ $pair){}
/*. int .*/ function ncurses_delwin(/*. resource .*/ $window){}
/*. int .*/ function ncurses_end(){}
/*. int .*/ function ncurses_getch(){}
/*. bool .*/ function ncurses_has_colors(){}
/*. int .*/ function ncurses_init(){}
/*. int .*/ function ncurses_init_pair(/*. int .*/ $pair, /*. int .*/ $fg, /*. int .*/ $bg){}
/*. int .*/ function ncurses_move(/*. int .*/ $y, /*. int .*/ $x){}
/*. resource .*/ function ncurses_newpad(/*. int .*/ $rows, /*. int .*/ $cols){}
/*. int .*/ function ncurses_prefresh(/*. resource .*/ $pad, /*. int .*/ $pminrow, /*. int .*/ $pmincol, /*. int .*/ $sminrow, /*. int .*/ $smincol, /*. int .*/ $smaxrow, /*. int .*/ $smaxcol){}
/*. int .*/ function ncurses_pnoutrefresh(/*. resource .*/ $pad, /*. int .*/ $pminrow, /*. int .*/ $pmincol, /*. int .*/ $sminrow, /*. int .*/ $smincol, /*. int .*/ $smaxrow, /*. int .*/ $smaxcol){}
/*. int .*/ function ncurses_newwin(/*. int .*/ $rows, /*. int .*/ $cols, /*. int .*/ $y, /*. int .*/ $x){}
/*. int .*/ function ncurses_refresh(/*. int .*/ $ch){}
/*. int .*/ function ncurses_start_color(){}
/*. int .*/ function ncurses_standout(){}
/*. int .*/ function ncurses_standend(){}
/*. int .*/ function ncurses_baudrate(){}
/*. int .*/ function ncurses_beep(){}
/*. bool .*/ function ncurses_can_change_color(){}
/*. bool .*/ function ncurses_cbreak(){}
/*. bool .*/ function ncurses_clear(){}
/*. bool .*/ function ncurses_clrtobot(){}
/*. bool .*/ function ncurses_clrtoeol(){}
/*. int .*/ function ncurses_reset_prog_mode(){}
/*. int .*/ function ncurses_reset_shell_mode(){}
/*. int .*/ function ncurses_def_prog_mode(){}
/*. int .*/ function ncurses_def_shell_mode(){}
/*. int .*/ function ncurses_delch(){}
/*. int .*/ function ncurses_deleteln(){}
/*. int .*/ function ncurses_doupdate(){}
/*. int .*/ function ncurses_echo(){}
/*. int .*/ function ncurses_erase(){}
/*. string .*/ function ncurses_erasechar(){}
/*. int .*/ function ncurses_flash(){}
/*. int .*/ function ncurses_flushinp(){}
/*. int .*/ function ncurses_has_ic(){}
/*. int .*/ function ncurses_has_il(){}
/*. string .*/ function ncurses_inch(){}
/*. int .*/ function ncurses_insertln(){}
/*. int .*/ function ncurses_isendwin(){}
/*. string .*/ function ncurses_killchar(){}
/*. int .*/ function ncurses_nl(){}
/*. int .*/ function ncurses_nocbreak(){}
/*. int .*/ function ncurses_noecho(){}
/*. int .*/ function ncurses_nonl(){}
/*. bool .*/ function ncurses_noraw(){}
/*. int .*/ function ncurses_raw(){}
/*. int .*/ function ncurses_werase(/*. resource .*/ $window){}
/*. int .*/ function ncurses_resetty(){}
/*. int .*/ function ncurses_savetty(){}
/*. int .*/ function ncurses_termattrs(){}
/*. int .*/ function ncurses_use_default_colors(){}
/*. int .*/ function ncurses_slk_attr(){}
/*. int .*/ function ncurses_slk_clear(){}
/*. int .*/ function ncurses_slk_noutrefresh(){}
/*. int .*/ function ncurses_slk_refresh(){}
/*. int .*/ function ncurses_slk_restore(){}
/*. int .*/ function ncurses_slk_touch(){}
/*. bool .*/ function ncurses_slk_set(/*. int .*/ $labelnr, /*. string .*/ $label, /*. int .*/ $format){}
/*. int .*/ function ncurses_attroff(/*. int .*/ $attributes){}
/*. int .*/ function ncurses_attron(/*. int .*/ $attributes){}
/*. int .*/ function ncurses_attrset(/*. int .*/ $attributes){}
/*. int .*/ function ncurses_bkgd(/*. int .*/ $attrchar){}
/*. int .*/ function ncurses_curs_set(/*. int .*/ $visibility){}
/*. int .*/ function ncurses_delay_output(/*. int .*/ $milliseconds){}
/*. int .*/ function ncurses_echochar(/*. int .*/ $character){}
/*. int .*/ function ncurses_halfdelay(/*. int .*/ $tenth){}
/*. int .*/ function ncurses_has_key(/*. int .*/ $keycode){}
/*. int .*/ function ncurses_insch(/*. int .*/ $character){}
/*. int .*/ function ncurses_insdelln(/*. int .*/ $count){}
/*. int .*/ function ncurses_mouseinterval(/*. int .*/ $milliseconds){}
/*. int .*/ function ncurses_napms(/*. int .*/ $milliseconds){}
/*. int .*/ function ncurses_scrl(/*. int .*/ $count){}
/*. int .*/ function ncurses_slk_attroff(/*. int .*/ $intarg){}
/*. int .*/ function ncurses_slk_attron(/*. int .*/ $intarg){}
/*. int .*/ function ncurses_slk_attrset(/*. int .*/ $intarg){}
/*. int .*/ function ncurses_slk_color(/*. int .*/ $intarg){}
/*. int .*/ function ncurses_slk_init(/*. int .*/ $intarg){}
/*. int .*/ function ncurses_typeahead(/*. int .*/ $fd){}
/*. int .*/ function ncurses_ungetch(/*. int .*/ $keycode){}
/*. int .*/ function ncurses_vidattr(/*. int .*/ $intarg){}
/*. int .*/ function ncurses_use_extended_names(/*. bool .*/ $flag){}
/*. void .*/ function ncurses_bkgdset(/*. int .*/ $attrchar){}
/*. void .*/ function ncurses_filter(){}
/*. int .*/ function ncurses_noqiflush(){}
/*. void .*/ function ncurses_qiflush(){}
/*. void .*/ function ncurses_timeout(/*. int .*/ $millisec){}
/*. void .*/ function ncurses_use_env(/*. int .*/ $flag){}
/*. int .*/ function ncurses_addstr(/*. string .*/ $text){}
/*. int .*/ function ncurses_putp(/*. string .*/ $text){}
/*. int .*/ function ncurses_scr_dump(/*. string .*/ $filename){}
/*. int .*/ function ncurses_scr_init(/*. string .*/ $filename){}
/*. int .*/ function ncurses_scr_restore(/*. string .*/ $filename){}
/*. int .*/ function ncurses_scr_set(/*. string .*/ $filename){}
/*. int .*/ function ncurses_mvaddch(/*. int .*/ $y, /*. int .*/ $x, /*. int .*/ $c){}
/*. int .*/ function ncurses_mvaddchnstr(/*. int .*/ $y, /*. int .*/ $x, /*. string .*/ $s, /*. int .*/ $n){}
/*. int .*/ function ncurses_addchnstr(/*. string .*/ $s, /*. int .*/ $n){}
/*. int .*/ function ncurses_mvaddchstr(/*. int .*/ $y, /*. int .*/ $x, /*. string .*/ $s){}
/*. int .*/ function ncurses_addchstr(/*. string .*/ $s){}
/*. int .*/ function ncurses_mvaddnstr(/*. int .*/ $y, /*. int .*/ $x, /*. string .*/ $s, /*. int .*/ $n){}
/*. int .*/ function ncurses_addnstr(/*. string .*/ $s, /*. int .*/ $n){}
/*. int .*/ function ncurses_mvaddstr(/*. int .*/ $y, /*. int .*/ $x, /*. string .*/ $s){}
/*. int .*/ function ncurses_mvdelch(/*. int .*/ $y, /*. int .*/ $x){}
/*. int .*/ function ncurses_mvgetch(/*. int .*/ $y, /*. int .*/ $x){}
/*. int .*/ function ncurses_mvinch(/*. int .*/ $y, /*. int .*/ $x){}
/*. int .*/ function ncurses_insstr(/*. string .*/ $text){}
/*. int .*/ function ncurses_instr(/*. return string .*/ &$buffer){}
/*. int .*/ function ncurses_mvhline(/*. int .*/ $y, /*. int .*/ $x, /*. int .*/ $attrchar, /*. int .*/ $n){}
/*. int .*/ function ncurses_mvvline(/*. int .*/ $y, /*. int .*/ $x, /*. int .*/ $attrchar, /*. int .*/ $n){}
/*. int .*/ function ncurses_mvcur(/*. int .*/ $old_y,/*. int .*/ $old_x, /*. int .*/ $new_y, /*. int .*/ $new_x){}
/*. int .*/ function ncurses_init_color(/*. int .*/ $color, /*. int .*/ $r, /*. int .*/ $g, /*. int .*/ $b){}
/*. int .*/ function ncurses_color_content(/*. int .*/ $color, /*. return int .*/ &$r, /*. return int .*/ &$g, /*. return int .*/ &$b){}
/*. int .*/ function ncurses_pair_content(/*. int .*/ $pair, /*. return int .*/ &$f, /*. return int .*/ &$b){}
/*. int .*/ function ncurses_border(/*. int .*/ $left, /*. int .*/ $right, /*. int .*/ $top, /*. int .*/ $bottom, /*. int .*/ $tl_corner, /*. int .*/ $tr_corner, /*. int .*/ $bl_corner, /*. int .*/ $br_corner){}
/*. int .*/ function ncurses_wborder(/*. resource .*/ $window, /*. int .*/ $left, /*. int .*/ $right, /*. int .*/ $top, /*. int .*/ $bottom, /*. int .*/ $tl_corner, /*. int .*/ $tr_corner, /*. int .*/ $bl_corner, /*. int .*/ $br_corner){}
/*. int .*/ function ncurses_assume_default_colors(/*. int .*/ $fg, /*. int .*/ $bg){}
/*. int .*/ function ncurses_define_key(/*. string .*/ $definition, /*. int .*/ $keycode){}
/*. int .*/ function ncurses_hline(/*. int .*/ $charattr, /*. int .*/ $n){}
/*. int .*/ function ncurses_vline(/*. int .*/ $charattr, /*. int .*/ $n){}
/*. int .*/ function ncurses_whline(/*. resource .*/ $window, /*. int .*/ $charattr, /*. int .*/ $n){}
/*. int .*/ function ncurses_wvline(/*. resource .*/ $window, /*. int .*/ $charattr, /*. int .*/ $n){}
/*. int .*/ function ncurses_keyok(/*. int .*/ $keycode, /*. int .*/ $enable){}
/*. int .*/ function ncurses_mvwaddstr(/*. resource .*/ $window, /*. int .*/ $y, /*. int .*/ $x, /*. string .*/ $text){}
/*. int .*/ function ncurses_wrefresh(/*. resource .*/ $window){}
/*. string .*/ function ncurses_termname(){}
/*. string .*/ function ncurses_longname(){}
/*. int .*/ function ncurses_mousemask(/*. int .*/ $newmask, /*. return int .*/ &$oldmask){}
/*. bool .*/ function ncurses_getmouse(/*. return array .*/ &$mevent){}
/*. int .*/ function ncurses_ungetmouse(/*. array .*/ $mevent){}
/*. bool .*/ function ncurses_mouse_trafo(/*. int .*/ &$y, /*. int .*/ &$x, /*. bool .*/ $toscreen){}
/*. bool .*/ function ncurses_wmouse_trafo(/*. resource .*/ $window, /*. int .*/ &$y, /*. int .*/ &$x, /*. bool .*/ $toscreen){}
/*. void .*/ function ncurses_getyx(/*. resource .*/ $window, /*. return int .*/ &$y, /*. return int .*/ &$x){}
/*. void .*/ function ncurses_getmaxyx(/*. resource .*/ $window, /*. return int .*/ &$y, /*. return int .*/ &$x){}
/*. int .*/ function ncurses_wmove(/*. resource .*/ $window, /*. int .*/ $y, /*. int .*/ $x){}
/*. int .*/ function ncurses_keypad(/*. resource .*/ $window, /*. bool .*/ $bf){}
/*. int .*/ function ncurses_wcolor_set(/*. resource .*/ $window, /*. int .*/ $color_pair){}
/*. int .*/ function ncurses_wclear(/*. resource .*/ $window){}
/*. int .*/ function ncurses_wnoutrefresh(/*. resource .*/ $window){}
/*. int .*/ function ncurses_waddstr(/*. resource .*/ $window, /*. string .*/ $str /*., args .*/){}
/*. int .*/ function ncurses_wgetch(/*. resource .*/ $window){}
/*. int .*/ function ncurses_wattroff(/*. resource .*/ $window, /*. int .*/ $attrs){}
/*. int .*/ function ncurses_wattron(/*. resource .*/ $window, /*. int .*/ $attrs){}
/*. int .*/ function ncurses_wattrset(/*. resource .*/ $window, /*. int .*/ $attrs){}
/*. int .*/ function ncurses_wstandend(/*. resource .*/ $window){}
/*. int .*/ function ncurses_wstandout(/*. resource .*/ $window){}
/*. resource .*/ function ncurses_new_panel(/*. resource .*/ $window){}
/*. bool .*/ function ncurses_del_panel(/*. resource .*/ $panel){}
/*. int .*/ function ncurses_hide_panel(/*. resource .*/ $panel){}
/*. int .*/ function ncurses_show_panel(/*. resource .*/ $panel){}
/*. int .*/ function ncurses_top_panel(/*. resource .*/ $panel){}
/*. int .*/ function ncurses_bottom_panel(/*. resource .*/ $panel){}
/*. int .*/ function ncurses_move_panel(/*. resource .*/ $panel, /*. int .*/ $startx, /*. int .*/ $starty){}
/*. int .*/ function ncurses_replace_panel(/*. resource .*/ $panel, /*. resource .*/ $window){}
/*. resource .*/ function ncurses_panel_above(/*. resource .*/ $panel){}
/*. resource .*/ function ncurses_panel_below(/*. resource .*/ $panel){}
/*. resource .*/ function ncurses_panel_window(/*. resource .*/ $panel){}
/*. void .*/ function ncurses_update_panels(){}
