<?php // lint >= 7.2

namespace PregMatchShapes;

use function PHPStan\Testing\assertType;
use InvalidArgumentException;

function doMatch(string $s): void {
	if (preg_match('/Price: /i', $s, $matches)) {
		assertType('array{string}', $matches);
	}
	assertType('array{}|array{string}', $matches);

	if (preg_match('/Price: (£|€)\d+/', $s, $matches)) {
		assertType('array{string, non-empty-string}', $matches);
	} else {
		assertType('array{}', $matches);
	}
	assertType('array{}|array{string, non-empty-string}', $matches);

	if (preg_match('/Price: (£|€)(\d+)/i', $s, $matches)) {
		assertType('array{string, non-empty-string, numeric-string}', $matches);
	}
	assertType('array{}|array{string, non-empty-string, numeric-string}', $matches);

	if (preg_match('  /Price: (£|€)\d+/ i u', $s, $matches)) {
		assertType('array{string, non-empty-string}', $matches);
	}
	assertType('array{}|array{string, non-empty-string}', $matches);

	if (preg_match('(Price: (£|€))i', $s, $matches)) {
		assertType('array{string, non-empty-string}', $matches);
	}
	assertType('array{}|array{string, non-empty-string}', $matches);

	if (preg_match('_foo(.)\_i_i', $s, $matches)) {
		assertType('array{string, non-empty-string}', $matches);
	}
	assertType('array{}|array{string, non-empty-string}', $matches);

	if (preg_match('/(a)(b)*(c)(d)*/', $s, $matches)) {
		assertType('array{0: string, 1: non-empty-string, 2: string, 3: non-empty-string, 4?: non-empty-string}', $matches);
	}
	assertType('array{}|array{0: string, 1: non-empty-string, 2: string, 3: non-empty-string, 4?: non-empty-string}', $matches);

	if (preg_match('/(a)(?<name>b)*(c)(d)*/', $s, $matches)) {
		assertType('array{0: string, 1: non-empty-string, name: string, 2: string, 3: non-empty-string, 4?: non-empty-string}', $matches);
	}
	assertType('array{}|array{0: string, 1: non-empty-string, name: string, 2: string, 3: non-empty-string, 4?: non-empty-string}', $matches);

	if (preg_match('/(a)(b)*(c)(?<name>d)*/', $s, $matches)) {
		assertType('array{0: string, 1: non-empty-string, 2: string, 3: non-empty-string, name?: non-empty-string, 4?: non-empty-string}', $matches);
	}
	assertType('array{}|array{0: string, 1: non-empty-string, 2: string, 3: non-empty-string, name?: non-empty-string, 4?: non-empty-string}', $matches);

	if (preg_match('/(a|b)|(?:c)/', $s, $matches)) {
		assertType('array{0: string, 1?: non-empty-string}', $matches);
	}
	assertType('array{}|array{0: string, 1?: non-empty-string}', $matches);

	if (preg_match('/(foo)(bar)(baz)+/', $s, $matches)) {
		assertType('array{string, non-empty-string, non-empty-string, non-empty-string}', $matches);
	}
	assertType('array{}|array{string, non-empty-string, non-empty-string, non-empty-string}', $matches);

	if (preg_match('/(foo)(bar)(baz)*/', $s, $matches)) {
		assertType('array{0: string, 1: non-empty-string, 2: non-empty-string, 3?: non-empty-string}', $matches);
	}
	assertType('array{}|array{0: string, 1: non-empty-string, 2: non-empty-string, 3?: non-empty-string}', $matches);

	if (preg_match('/(foo)(bar)(baz)?/', $s, $matches)) {
		assertType('array{0: string, 1: non-empty-string, 2: non-empty-string, 3?: non-empty-string}', $matches);
	}
	assertType('array{}|array{0: string, 1: non-empty-string, 2: non-empty-string, 3?: non-empty-string}', $matches);

	if (preg_match('/(foo)(bar)(baz){0,3}/', $s, $matches)) {
		assertType('array{0: string, 1: non-empty-string, 2: non-empty-string, 3?: non-empty-string}', $matches);
	}
	assertType('array{}|array{0: string, 1: non-empty-string, 2: non-empty-string, 3?: non-empty-string}', $matches);

	if (preg_match('/(foo)(bar)(baz){2,3}/', $s, $matches)) {
		assertType('array{string, non-empty-string, non-empty-string, non-empty-string}', $matches);
	}
	assertType('array{}|array{string, non-empty-string, non-empty-string, non-empty-string}', $matches);

	if (preg_match('/(foo)(bar)(baz){2}/', $s, $matches)) {
		assertType('array{string, non-empty-string, non-empty-string, non-empty-string}', $matches);
	}
	assertType('array{}|array{string, non-empty-string, non-empty-string, non-empty-string}', $matches);
}

function doNonCapturingGroup(string $s): void {
	if (preg_match('/Price: (?:£|€)(\d+)/', $s, $matches)) {
		assertType('array{string, numeric-string}', $matches);
	}
	assertType('array{}|array{string, numeric-string}', $matches);
}

function doNamedSubpattern(string $s): void {
	if (preg_match('/\w-(?P<num>\d+)-(\w)/', $s, $matches)) {
		assertType('array{0: string, num: numeric-string, 1: numeric-string, 2: non-empty-string}', $matches);
	}
	assertType('array{}|array{0: string, num: numeric-string, 1: numeric-string, 2: non-empty-string}', $matches);

	if (preg_match('/^(?<name>\S+::\S+)/', $s, $matches)) {
		assertType('array{0: string, name: non-empty-string, 1: non-empty-string}', $matches);
	}
	assertType('array{}|array{0: string, name: non-empty-string, 1: non-empty-string}', $matches);

	if (preg_match('/^(?<name>\S+::\S+)(?:(?<dataname> with data set (?:#\d+|"[^"]+"))\s\()?/', $s, $matches)) {
		assertType('array{0: string, name: non-empty-string, 1: non-empty-string, dataname?: non-empty-string, 2?: non-empty-string}', $matches);
	}
	assertType('array{}|array{0: string, name: non-empty-string, 1: non-empty-string, dataname?: non-empty-string, 2?: non-empty-string}', $matches);
}

function doOffsetCapture(string $s): void {
	if (preg_match('/(foo)(bar)(baz)/', $s, $matches, PREG_OFFSET_CAPTURE)) {
		assertType('array{array{string, int<0, max>}, array{non-empty-string, int<0, max>}, array{non-empty-string, int<0, max>}, array{non-empty-string, int<0, max>}}', $matches);
	}
	assertType('array{}|array{array{string, int<0, max>}, array{non-empty-string, int<0, max>}, array{non-empty-string, int<0, max>}, array{non-empty-string, int<0, max>}}', $matches);
}

function doUnknownFlags(string $s, int $flags): void {
	if (preg_match('/(foo)(bar)(baz)/xyz', $s, $matches, $flags)) {
		assertType('array<array{string|null, int<-1, max>}|string|null>', $matches);
	}
	assertType('array<array{string|null, int<-1, max>}|string|null>', $matches);
}

function doMultipleAlternativeCaptureGroupsWithSameNameWithModifier(string $s): void {
	if (preg_match('/(?J)(?<Foo>[a-z]+)|(?<Foo>[0-9]+)/', $s, $matches)) {
		assertType('array{0: string, Foo: numeric-string|non-empty-string, 1: non-empty-string, 2?: numeric-string}', $matches);
	}
	assertType('array{}|array{0: string, Foo: numeric-string|non-empty-string, 1: non-empty-string, 2?: numeric-string}', $matches);
}

function doMultipleConsecutiveCaptureGroupsWithSameNameWithModifier(string $s): void {
	if (preg_match('/(?J)(?<Foo>[a-z]+)|(?<Foo>[0-9]+)/', $s, $matches)) {
		assertType('array{0: string, Foo: numeric-string|non-empty-string, 1: non-empty-string, 2?: numeric-string}', $matches);
	}
	assertType('array{}|array{0: string, Foo: numeric-string|non-empty-string, 1: non-empty-string, 2?: numeric-string}', $matches);
}

// https://github.com/hoaproject/Regex/issues/31
function hoaBug31(string $s): void {
	if (preg_match('/([\w-])/', $s, $matches)) {
		assertType('array{string, non-empty-string}', $matches);
	}
	assertType('array{}|array{string, non-empty-string}', $matches);

	if (preg_match('/\w-(\d+)-(\w)/', $s, $matches)) {
		assertType('array{string, numeric-string, non-empty-string}', $matches);
	}
	assertType('array{}|array{string, numeric-string, non-empty-string}', $matches);
}

// https://github.com/phpstan/phpstan/issues/10855#issuecomment-2044323638
function testHoaUnsupportedRegexSyntax(string $s): void {
	if (preg_match('#\QPHPDoc type array<string> of property App\Log::$fillable is not covariant with PHPDoc type array<int, string> of overridden property Illuminate\Database\E\\\\\QEloquent\Model::$fillable.\E#', $s, $matches)) {
		assertType('array{string}', $matches);
	}
	assertType('array{}|array{string}', $matches);
}

function testPregMatchSimpleCondition(string $value): void {
	if (preg_match('/%env\((.*)\:.*\)%/U', $value, $matches)) {
		assertType('array{string, string}', $matches);
	}
}


function testPregMatchIdenticalToOne(string $value): void {
	if (preg_match('/%env\((.*)\:.*\)%/U', $value, $matches) === 1) {
		assertType('array{string, string}', $matches);
	}
}

function testPregMatchIdenticalToOneFalseyContext(string $value): void {
	if (!(preg_match('/%env\((.*)\:.*\)%/U', $value, $matches) !== 1)) {
		assertType('array{string, string}', $matches);
	}
}

function testPregMatchIdenticalToOneInverted(string $value): void {
	if (1 === preg_match('/%env\((.*)\:.*\)%/U', $value, $matches)) {
		assertType('array{string, string}', $matches);
	}
}

function testPregMatchIdenticalToOneFalseyContextInverted(string $value): void {
	if (!(1 !== preg_match('/%env\((.*)\:.*\)%/U', $value, $matches))) {
		assertType('array{string, string}', $matches);
	}
}

function testPregMatchEqualToOne(string $value): void {
	if (preg_match('/%env\((.*)\:.*\)%/U', $value, $matches) == 1) {
		assertType('array{string, string}', $matches);
	}
}

function testPregMatchEqualToOneFalseyContext(string $value): void {
	if (!(preg_match('/%env\((.*)\:.*\)%/U', $value, $matches) != 1)) {
		assertType('array{string, string}', $matches);
	}
}

function testPregMatchEqualToOneInverted(string $value): void {
	if (1 == preg_match('/%env\((.*)\:.*\)%/U', $value, $matches)) {
		assertType('array{string, string}', $matches);
	}
}

function testPregMatchEqualToOneFalseyContextInverted(string $value): void {
	if (!(1 != preg_match('/%env\((.*)\:.*\)%/U', $value, $matches))) {
		assertType('array{string, string}', $matches);
	}
}

function testUnionPattern(string $s): void
{
	if (rand(0,1)) {
		$pattern = '/Price: (\d+)/i';
	} else {
		$pattern = '/Price: (\d+)(\d+)(\d+)/';
	}
	if (preg_match($pattern, $s, $matches)) {
		assertType('array{string, numeric-string, numeric-string, numeric-string}|array{string, numeric-string}', $matches);
	}
	assertType('array{}|array{string, numeric-string, numeric-string, numeric-string}|array{string, numeric-string}', $matches);
}

function doFoo(string $row): void
{
	if (preg_match('~^(a(b))$~', $row, $matches) === 1) {
		assertType('array{string, non-empty-string, non-empty-string}', $matches);
	}
	if (preg_match('~^(a(b)?)$~', $row, $matches) === 1) {
		assertType('array{0: string, 1: non-empty-string, 2?: non-empty-string}', $matches);
	}
	if (preg_match('~^(a(b)?)?$~', $row, $matches) === 1) {
		assertType('array{0: string, 1?: non-empty-string, 2?: non-empty-string}', $matches);
	}
}

function doFoo2(string $row): void
{
	if (preg_match('~^((?<branchCode>\\d{1,6})-)?(?<accountNumber>\\d{1,10})/(?<bankCode>\\d{4})$~', $row, $matches) !== 1) {
		return;
	}

	assertType("array{0: string, 1: string, branchCode: ''|numeric-string, 2: ''|numeric-string, accountNumber: numeric-string, 3: numeric-string, bankCode: numeric-string, 4: numeric-string}", $matches);
}

function doFoo3(string $row): void
{
	if (preg_match('~^(02,([\d.]{10}),(\d+),(\d+),(\d+),)(\d+)$~', $row, $matches) !== 1) {
		return;
	}

	assertType('array{string, non-empty-string, non-empty-string, numeric-string, numeric-string, numeric-string, numeric-string}', $matches);
}

function (string $size): void {
	if (preg_match('~^a\.b(c(\d+)(\d+)(\s+))?d~', $size, $matches) !== 1) {
		throw new InvalidArgumentException(sprintf('Invalid size "%s"', $size));
	}
	assertType('array{string, non-empty-string, numeric-string, numeric-string, non-empty-string}|array{string}', $matches);
};

function (string $size): void {
	if (preg_match('~^a\.b(c(\d+))?d~', $size, $matches) !== 1) {
		throw new InvalidArgumentException(sprintf('Invalid size "%s"', $size));
	}
	assertType('array{string, non-empty-string, numeric-string}|array{string}', $matches);
};

function (string $size): void {
	if (preg_match('~^a\.b(c(\d+)?)d~', $size, $matches) !== 1) {
		throw new InvalidArgumentException(sprintf('Invalid size "%s"', $size));
	}
	assertType('array{0: string, 1: non-empty-string, 2?: numeric-string}', $matches);
};

function (string $size): void {
	if (preg_match('~^a\.b(c(\d+)?)?d~', $size, $matches) !== 1) {
		throw new InvalidArgumentException(sprintf('Invalid size "%s"', $size));
	}
	assertType('array{0: string, 1?: non-empty-string, 2?: numeric-string}', $matches);
};

function (string $size): void {
	if (preg_match('~^a\.b(c(\d+))d~', $size, $matches) !== 1) {
		throw new InvalidArgumentException(sprintf('Invalid size "%s"', $size));
	}
	assertType('array{string, non-empty-string, numeric-string}', $matches);
};

function (string $size): void {
	if (preg_match('~^a\.(b)?(c)?d~', $size, $matches) !== 1) {
		throw new InvalidArgumentException(sprintf('Invalid size "%s"', $size));
	}
	assertType('array{0: string, 1?: non-empty-string, 2?: non-empty-string}', $matches);
};

function (string $size): void {
	if (preg_match('~^(?:(\\d+)x(\\d+)|(\\d+)|x(\\d+))$~', $size, $matches) !== 1) {
		throw new InvalidArgumentException(sprintf('Invalid size "%s"', $size));
	}
	assertType('array{0: string, 1: numeric-string, 2: numeric-string, 3?: numeric-string, 4?: numeric-string}', $matches);
};

function (string $size): void {
	if (preg_match('~^(?:(\\d+)x(\\d+)|(\\d+)|x(\\d+))?$~', $size, $matches) !== 1) {
		throw new InvalidArgumentException(sprintf('Invalid size "%s"', $size));
	}
	assertType('array{0: string, 1: numeric-string, 2: numeric-string, 3?: numeric-string, 4?: numeric-string}|array{string}', $matches);
};

function (string $size): void {
	if (preg_match('~\{(?:(include)\\s+(?:[$]?\\w+(?<!file))\\s)|(?:(include\\s+file)\\s+(?:[$]?\\w+)\\s)|(?:(include(?:Template|(?:\\s+file)))\\s+(?:\'?.*?\.latte\'?)\\s)~', $size, $matches) !== 1) {
		throw new InvalidArgumentException(sprintf('Invalid size "%s"', $size));
	}
	assertType('array{0: string, 1: non-empty-string, 2?: non-empty-string, 3?: non-empty-string}', $matches);
};


function bug11277a(string $value): void
{
	if (preg_match('/^\[(.+,?)*\]$/', $value, $matches)) {
		assertType('array{0: string, 1?: non-empty-string}', $matches);
		if (count($matches) === 2) {
			assertType('array{string, string}', $matches); // could be array{string, non-empty-string}
		}
	}
}

function bug11277b(string $value): void
{
	if (preg_match('/^(?:(.+,?)|(x))*$/', $value, $matches)) {
		assertType('array{0: string, 1?: non-empty-string, 2?: non-empty-string}', $matches);
		if (count($matches) === 2) {
			assertType('array{string, string}', $matches); // could be array{string, non-empty-string}
		}
		if (count($matches) === 3) {
			assertType('array{string, string, string}', $matches); // could be array{string, non-empty-string, non-empty-string}
		}
	}
}

// https://www.pcre.org/current/doc/html/pcre2pattern.html#dupgroupnumber
// https://3v4l.org/09qdT
function bug11291(string $s): void {
	if (preg_match('/(?|(a)|(b)(c)|(d)(e)(f))/', $s, $matches)) {
		assertType('array{0: string, 1: non-empty-string, 2?: non-empty-string, 3?: non-empty-string}', $matches);
	} else {
		assertType('array{}', $matches);
	}
	assertType('array{}|array{0: string, 1: non-empty-string, 2?: non-empty-string, 3?: non-empty-string}', $matches);
}

function bug11323a(string $s): void
{
	if (preg_match('/Price: (?P<currency>£|€)\d+/', $s, $matches)) {
		assertType('array{0: string, currency: non-empty-string, 1: non-empty-string}', $matches);
	} else {
		assertType('array{}', $matches);
	}
	assertType('array{}|array{0: string, currency: non-empty-string, 1: non-empty-string}', $matches);
}

function bug11323b(string $s): void
{
	if (preg_match('/Price: (?<currency>£|€)\d+/', $s, $matches)) {
		assertType('array{0: string, currency: non-empty-string, 1: non-empty-string}', $matches);
	} else {
		assertType('array{}', $matches);
	}
	assertType('array{}|array{0: string, currency: non-empty-string, 1: non-empty-string}', $matches);
}

function unmatchedAsNullWithMandatoryGroup(string $s): void {
	if (preg_match('/Price: (?<currency>£|€)\d+/', $s, $matches, PREG_UNMATCHED_AS_NULL)) {
		assertType('array{0: string, currency: non-empty-string, 1: non-empty-string}', $matches);
	} else {
		assertType('array{}', $matches);
	}
	assertType('array{}|array{0: string, currency: non-empty-string, 1: non-empty-string}', $matches);
}

function (string $s): void {
	if (preg_match('{' . preg_quote('xxx') . '(z)}', $s, $matches)) {
		assertType('array{string, non-empty-string}', $matches);
	} else {
		assertType('array{}', $matches);
	}
	assertType('array{}|array{string, non-empty-string}', $matches);
};

function (string $s): void {
	if (preg_match('{' . preg_quote($s) . '(z)}', $s, $matches)) {
		assertType('array{string, non-empty-string}', $matches);
	} else {
		assertType('array{}', $matches);
	}
	assertType('array{}|array{string, non-empty-string}', $matches);
};

function (string $s): void {
	if (preg_match('/' . preg_quote($s, '/') . '(\d)/', $s, $matches)) {
		assertType('array{string, numeric-string}', $matches);
	} else {
		assertType('array{}', $matches);
	}
	assertType('array{}|array{string, numeric-string}', $matches);
};

function (string $s): void {
	if (preg_match('{' . preg_quote($s) . '(z)' . preg_quote($s) . '(?:abc)(def)?}', $s, $matches)) {
		assertType('array{0: string, 1: non-empty-string, 2?: non-empty-string}', $matches);
	} else {
		assertType('array{}', $matches);
	}
	assertType('array{}|array{0: string, 1: non-empty-string, 2?: non-empty-string}', $matches);
};

function (string $s, $mixed): void {
	if (preg_match('{' . preg_quote($s) . '(z)' . preg_quote($s) . '(?:abc)'. $mixed .'(def)?}', $s, $matches)) {
		assertType('array<string>', $matches);
	} else {
		assertType('array{}', $matches);
	}
	assertType('array<string>', $matches);
};

function (string $s): void {
	if (preg_match('/^%([0-9]*\$)?[0-9]*\.?[0-9]*([sbdeEfFgGhHouxX])$/', $s, $matches) === 1) {
		assertType('array{string, string, non-empty-string}', $matches);
	}
};

function (string $s): void {
	if (preg_match('~^((\\d{1,6})-)$~', $s, $matches) === 1) {
		assertType("array{string, non-empty-string, numeric-string}", $matches);
	}
};

function (string $s): void {
	if (preg_match('~^((\\d{1,6}).)$~', $s, $matches) === 1) {
		assertType("array{string, non-empty-string, numeric-string}", $matches);
	}
};

function (string $s): void {
	if (preg_match('~^([157])$~', $s, $matches) === 1) {
		assertType("array{string, numeric-string}", $matches);
	}
};

function (string $s): void {
	if (preg_match('~^([157XY])$~', $s, $matches) === 1) {
		assertType("array{string, non-empty-string}", $matches);
	}
};

function bug11323(string $s): void {
	if (preg_match('/([*|+?{}()]+)([^*|+[:digit:]?{}()]+)/', $s, $matches)) {
		assertType('array{string, non-empty-string, non-empty-string}', $matches);
	}
	if (preg_match('/\p{L}[[\]]+([-*|+?{}(?:)]+)([^*|+[:digit:]?{a-z}(\p{L})\a-]+)/', $s, $matches)) {
		assertType('array{string, non-empty-string, non-empty-string}', $matches);
	}
	if (preg_match('{([-\p{L}[\]*|\x03\a\b+?{}(?:)-]+[^[:digit:]?{}a-z0-9#-k]+)(a-z)}', $s, $matches)) {
		assertType('array{string, non-empty-string, non-empty-string}', $matches);
	}
	if (preg_match('{(\d+)(?i)insensitive((?x-i)case SENSITIVE here(?i:insensitive non-capturing group))}', $s, $matches)) {
		assertType('array{string, numeric-string, non-empty-string}', $matches);
	}
	if (preg_match('{([]] [^]])}', $s, $matches)) {
		assertType('array{string, non-empty-string}', $matches);
	}
	if (preg_match('{([[:digit:]])}', $s, $matches)) {
		assertType('array{string, numeric-string}', $matches);
	}
	if (preg_match('{([\d])(\d)}', $s, $matches)) {
		assertType('array{string, numeric-string, numeric-string}', $matches);
	}
	if (preg_match('{([0-9])}', $s, $matches)) {
		assertType('array{string, numeric-string}', $matches);
	}
	if (preg_match('{(\p{L})(\p{P})(\p{Po})}', $s, $matches)) {
		assertType('array{string, non-empty-string, non-empty-string, non-empty-string}', $matches);
	}
	if (preg_match('{(a)??(b)*+(c++)(d)+?}', $s, $matches)) {
		assertType('array{string, string, string, non-empty-string, non-empty-string}', $matches);
	}
	if (preg_match('{(.\d)}', $s, $matches)) {
		assertType('array{string, non-empty-string}', $matches);
	}
	if (preg_match('{(\d.)}', $s, $matches)) {
		assertType('array{string, non-empty-string}', $matches);
	}
	if (preg_match('{(\d\d)}', $s, $matches)) {
		assertType('array{string, numeric-string}', $matches);
	}
	if (preg_match('{(.(\d))}', $s, $matches)) {
		assertType('array{string, non-empty-string, numeric-string}', $matches);
	}
	if (preg_match('{((\d).)}', $s, $matches)) {
		assertType('array{string, non-empty-string, numeric-string}', $matches);
	}
	if (preg_match('{(\d([1-4])\d)}', $s, $matches)) {
		assertType('array{string, numeric-string, numeric-string}', $matches);
	}
	if (preg_match('{(x?([1-4])\d)}', $s, $matches)) {
		assertType('array{string, non-empty-string, numeric-string}', $matches);
	}
	if (preg_match('{([^1-4])}', $s, $matches)) {
		assertType('array{string, non-empty-string}', $matches);
	}
	if (preg_match("{([\r\n]+)(\n)([\n])}", $s, $matches)) {
		assertType('array{string, non-empty-string, non-empty-string, non-empty-string}', $matches);
	}
	if (preg_match('/foo(*:first)|bar(*:second)([x])/', $s, $matches)) {
		assertType("array{0: string, 1?: non-empty-string, MARK?: 'first'|'second'}", $matches);
	}
}

function (string $s): void {
	preg_match('/%a(\d*)/', $s, $matches);
	assertType("array{0?: string, 1?: ''|numeric-string}", $matches);
};

class Bug11376
{
	public function test(string $str): void
	{
		preg_match('~^(?:(\w+)::)?(\w+)$~', $str, $matches);
		assertType('array{0?: string, 1?: string, 2?: non-empty-string}', $matches);
	}

	public function test2(string $str): void
	{
		if (preg_match('~^(?:(\w+)::)?(\w+)$~', $str, $matches) === 1) {
			assertType('array{string, string, non-empty-string}', $matches);
		}
	}
}
