<?php
/** Tokenizer Functions.

	NOTE. Since PHP 4.3.0, the tokenizer module is effectively
	built-in by default and can be disabled explicitly with
	./configure --disable-tokenizer when compiling from the source.
	<p>

	See: {@link http://www.php.net/manual/en/ref.tokenizer.php}
	@package tokenizer
*/

const T_ABSTRACT = 315,
	T_AND_EQUAL = 275,
	T_ARRAY = 368,
	T_ARRAY_CAST = 298,
	T_AS = 338,
	T_BOOLEAN_AND = 284,
	T_BOOLEAN_OR = 283,
	T_BOOL_CAST = 296,
	T_BREAK = 343,
	T_CALLABLE = 369,
	T_CASE = 341,
	T_CATCH = 350,
	T_CLASS = 361,
	T_CLASS_C = 373,
	T_CLONE = 305,
	T_CLOSE_TAG = 381,
	T_COALESCE = 282,
	T_COMMENT = 377,
	T_CONCAT_EQUAL = 277,
	T_CONST = 347,
	T_CONSTANT_ENCAPSED_STRING = 323,
	T_CONTINUE = 344,
	T_CURLY_OPEN = 386,
	T_DEC = 302,
	T_DECLARE = 336,
	T_DEFAULT = 342,
	T_DIR = 372,
	T_DIV_EQUAL = 278,
	T_DNUMBER = 318,
	T_DO = 329,
	T_DOC_COMMENT = 378,
	T_DOLLAR_OPEN_CURLY_BRACES = 385,
	T_DOUBLE_ARROW = 268,
	T_DOUBLE_CAST = 300,
	T_DOUBLE_COLON = 387,
	T_ECHO = 328,
	T_ELLIPSIS = 391,
	T_ELSE = 309,
	T_ELSEIF = 308,
	T_EMPTY = 359,
	T_ENCAPSED_AND_WHITESPACE = 322,
	T_ENDDECLARE = 337,
	T_ENDFOR = 333,
	T_ENDFOREACH = 335,
	T_ENDIF = 310,
	T_ENDSWITCH = 340,
	T_ENDWHILE = 331,
	T_END_HEREDOC = 384,
	T_EVAL = 260,
	T_EXIT = 326,
	T_EXTENDS = 364,
	T_FILE = 371,
	T_FINAL = 314,
	T_FINALLY = 351,
	T_FOR = 332,
	T_FOREACH = 334,
	T_FUNCTION = 346,
	T_FUNC_C = 376,
	T_GLOBAL = 355,
	T_GOTO = 345,
	T_HALT_COMPILER = 360,
	T_IF = 327,
	T_IMPLEMENTS = 365,
	T_INC = 303,
	T_INCLUDE = 262,
	T_INCLUDE_ONCE = 261,
	T_INLINE_HTML = 321,
	T_INSTANCEOF = 294,
	T_INSTEADOF = 354,
	T_INTERFACE = 363,
	T_INT_CAST = 301,
	T_ISSET = 358,
	T_IS_EQUAL = 289,
	T_IS_GREATER_OR_EQUAL = 290,
	T_IS_IDENTICAL = 287,
	T_IS_NOT_EQUAL = 288,
	T_IS_NOT_IDENTICAL = 286,
	T_IS_SMALLER_OR_EQUAL = 291,
	T_LINE = 370,
	T_LIST = 367,
	T_LNUMBER = 317,
	T_LOGICAL_AND = 265,
	T_LOGICAL_OR = 263,
	T_LOGICAL_XOR = 264,
	T_METHOD_C = 375,
	T_MINUS_EQUAL = 280,
	T_MOD_EQUAL = 276,
	T_MUL_EQUAL = 279,
	T_NAMESPACE = 388,
	T_NEW = 306,
	T_NS_C = 389,
	T_NS_SEPARATOR = 390,
	T_NUM_STRING = 325,
	T_OBJECT_CAST = 297,
	T_OBJECT_OPERATOR = 366,
	T_OPEN_TAG = 379,
	T_OPEN_TAG_WITH_ECHO = 380,
	T_OR_EQUAL = 274,
	T_PAAMAYIM_NEKUDOTAYIM = 387,
	T_PLUS_EQUAL = 281,
	T_POW = 304,
	T_POW_EQUAL = 270,
	T_PRINT = 266,
	T_PRIVATE = 313,
	T_PROTECTED = 312,
	T_PUBLIC = 311,
	T_REQUIRE = 259,
	T_REQUIRE_ONCE = 258,
	T_RETURN = 348,
	T_SL = 293,
	T_SL_EQUAL = 272,
	T_SPACESHIP = 285,
	T_SR = 292,
	T_SR_EQUAL = 271,
	T_START_HEREDOC = 383,
	T_STATIC = 316,
	T_STRING = 319,
	T_STRING_CAST = 299,
	T_STRING_VARNAME = 324,
	T_SWITCH = 339,
	T_THROW = 352,
	T_TRAIT = 362,
	T_TRAIT_C = 374,
	T_TRY = 349,
	T_UNSET = 357,
	T_UNSET_CAST = 295,
	T_USE = 353,
	T_VAR = 356,
	T_VARIABLE = 320,
	T_WHILE = 330,
	T_WHITESPACE = 382,
	T_XOR_EQUAL = 273,
	T_YIELD = 267,
	T_YIELD_FROM = 269;

/*. mixed[int] .*/ function token_get_all(/*. string .*/ $source){}
/*. string.*/ function token_name(/*. int .*/ $type){}
