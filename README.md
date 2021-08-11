# PHP Coding Standards

The PHOS team is working to gradually improve code structure by helping users maintain a consistent style so the code can become clean and easy to read at a glance.

## PHP

### Single and Double Quotes

Use single and double quotes when appropriate. If you're not evaluating anything in the string, use single quotes. You should almost never have to escape quotes in a string, because you can just alternate your quoting style, like so:

```php
echo '<a href="/static/link" title="Yeah yeah!">Link name</a>';
echo "<a href='$link' title='$linktitle'>$linkname</a>";
```

Text that goes into attributes should be run through `esc_attr()` so that single or double quotes do not end the attribute value and invalidate the HTML and cause a security issue. See <a href="http://codex.wordpress.org/Data_Validation">Data Validation</a> in the Codex for further details.

### Indentation

Your indentation should always reflect logical structure. Use **_real tabs_** and **_not spaces_**, as this allows the most flexibility across clients.

Exception: if you have a block of code that would be more readable if things are aligned, use spaces:

```php
[tab]$foo   = 'somevalue';
[tab]$foo2  = 'somevalue2';
[tab]$foo34 = 'somevalue3';
[tab]$foo5  = 'somevalue4';
```

For associative arrays, **each item** should start on a new line when the array contains more than one item:

```php
$query = new WP_Query( array( 'ID' => 123 ) );
```

```php
$args = array(
[tab]'post_type'   => 'page',
[tab]'post_author' => 123,
[tab]'post_status' => 'publish',
);

$query = new WP_Query( $args );
```

Note the comma after the last array item: this is recommended because it makes it easier to change the order of the array, and makes for cleaner diffs when new items are added.

```php
$my_array = array(
[tab]'foo'   => 'somevalue',
[tab]'foo2'  => 'somevalue2',
[tab]'foo3'  => 'somevalue3',
[tab]'foo34' => 'somevalue3',
);
```

For `switch` structures `case` should indent one tab from the `switch` statement and `break` one tab from the `case` statement.

```php
switch ( $type ) {
[tab]case 'foo':
[tab][tab]some_function();
[tab][tab]break;
[tab]case 'bar':
[tab][tab]some_function();
[tab][tab]break;
}
```

**_Rule of thumb:_** Tabs should be used at the beginning of the line for indentation, while spaces can be used mid-line for alignment.

### Brace Style

Braces shall be used for all blocks in the style shown here:

```php
if ( condition ) {
	action1();
	action2();
} elseif ( condition2 && condition3 ) {
	action3();
	action4();
} else {
	defaultaction();
}
```

If you have a really long block, consider whether it can be broken into two or more shorter blocks, functions, or methods, to reduce complexity, improve ease of testing, and increase readability.

Braces should always be used, even when they are not required:

```php
if ( condition ) {
	action0();
}

if ( condition ) {
	action1();
} elseif ( condition2 ) {
	action2a();
	action2b();
}

foreach ( $items as $item ) {
	process_item( $item );
}
```

Note that requiring the use of braces just means that **single-statement inline control structures** are prohibited. You are free to use the <a href="http://php.net/manual/en/control-structures.alternative-syntax.php" rel="nofollow">alternative syntax for control structures</a> (e.g. `if`/`endif`, `while`/`endwhile`)—especially in your templates where PHP code is embedded within HTML, for instance:

```php
<?php if ( have_posts() ) : ?>
	<div class="hfeed">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID() ?>" class="<?php post_class() ?>">
				<!-- ... -->
			</article>
		<?php endwhile; ?>
	</div>
<?php endif; ?>
```

### Use `elseif`, not `else if`

`else if` is not compatible with the colon syntax for `if|elseif` blocks. For this reason, use `elseif` for conditionals.

### Declaring Arrays

Using long array syntax ( `array( 1, 2, 3 )` ) for declaring arrays is generally more readable than short array syntax ( `[ 1, 2, 3 ]` ), particularly for those with vision difficulties. Additionally, it's much more descriptive for beginners.

Arrays must be declared using long array syntax.

### Multiline Function Calls

When splitting a function call over multiple lines, each parameter must be on a separate line. Single line inline comments can take up their own line.

Each parameter must take up no more than a single line. Multi-line parameter values must be assigned to a variable and then that variable should be passed to the function call.

```php
$bar = array(
    'use_this' => true,
    'meta_key' => 'field_name',
);

$baz = sprintf(
    /* translators: %s: Friend's name */
    esc_html__( 'Hello, %s!', 'yourtextdomain' ),
    $friend_name
);

$a = foo(
    $bar,
    $baz,
    /* translators: %s: cat */
    sprintf( __( 'The best pet is a %s.' ), 'cat' )
);
```

### Opening and Closing PHP Tags

When embedding multi-line PHP snippets within an HTML block, the PHP open and close tags must be on a line by themselves.

Correct (Multiline):

```php
function foo() {
    ?>
    <div>
        <?php
        echo bar(
            $baz,
            $bat
        );
        ?>
    </div>
    <?php
}
```

Correct (Single Line):

```php
<input name="<?php echo esc_attr( $name ); ?>" />
```

Incorrect:

```php
if ( $a === $b ) { ?>
<some html>
<?php }
```

### No Shorthand PHP Tags

<strong>Important:</strong> Never use shorthand PHP start tags. Always use full PHP tags.

Correct:

```php
<?php ... ?>
<?php echo $var; ?>
```

Incorrect:

```php
<? ... ?>
<?= $var ?>
```

### Remove Trailing Spaces

Remove trailing whitespace at the end of each line of code. Omitting the closing PHP tag at the end of a file is preferred. If you use the tag, make sure you remove trailing whitespace.

### Space Usage

Always put spaces after commas, and on both sides of logical, comparison, string and assignment operators.

```php
x === 23
foo && bar
! foo
array( 1, 2, 3 )
$baz . '-5'
$term .= 'X'
```

Put spaces on both sides of the opening and closing parentheses of `if`, `elseif`, `foreach`, `for`, and `switch` blocks.

```php
foreach ( $foo as $bar ) { ...
```

When defining a function, do it like so:

```php
function my_function( $param1 = 'foo', $param2 = 'bar' ) { ...

function my_other_function() { ...
```

When calling a function, do it like so:

```php
my_function( $param1, func_param( $param2 ) );
my_other_function();
```

When performing logical comparisons, do it like so:

```php
if ( ! $foo ) { ...
```

<a title="type casting" href="http://www.php.net/manual/en/language.types.type-juggling.php#language.types.typecasting" target="_blank">Type casts</a> must be lowercase. Always prefer the short form of type casts, `(int)` instead of `(integer)` and `(bool)` rather than `(boolean)`. For float casts use `(float)`.:

```php
foreach ( (array) $foo as $bar ) { ...

$foo = (bool) $bar;
```

When referring to array items, only include a space around the index if it is a variable, for example:

```php
$x = $foo['bar']; // correct
$x = $foo[ 'bar' ]; // incorrect

$x = $foo[0]; // correct
$x = $foo[ 0 ]; // incorrect

$x = $foo[ $bar ]; // correct
$x = $foo[$bar]; // incorrect
```

In a `switch` block, there must be no space before the colon for a case statement.

```php
switch ( $foo ) {
	case 'bar': // correct
	case 'ba' : // incorrect
}
```

Similarly, there should be no space before the colon on return type declarations.

```php
function sum( $a, $b ): float {
	return $a + $b;
}
```

Unless otherwise specified, parentheses should have spaces inside of them.

```php
if ( $foo && ( $bar || $baz ) ) { ...

my_function( ( $x - 1 ) * 5, $y );
```

### Database Queries

Avoid touching the database directly. If there is a defined function that can get the data you need, use it. Database abstraction (using functions instead of queries) helps keep your code forward-compatible and, in cases where results are cached in memory, it can be many times faster.

### Naming Conventions

Use lowercase letters in variable, action/filter, and function names (never `camelCase`). Separate words via underscores. Don't abbreviate variable names unnecessarily; let the code be unambiguous and self-documenting.

```php
function some_name( $some_variable ) { [...] }
```

Class names should use capitalized words separated by underscores. Any acronyms should be all upper case.

```php
class Walker_Category extends Walker { [...] }
class WP_HTTP { [...] }
```

Constants should be in all upper-case with underscores separating words:

```php
define( 'DOING_AJAX', true );
```

### Self-Explanatory Flag Values for Function Arguments

Prefer string values to just `true` and `false` when calling functions.

```php
// Incorrect
function eat( $what, $slowly = true ) {
...
}
eat( 'mushrooms' );
eat( 'mushrooms', true ); // what does true mean?
eat( 'dogfood', false ); // what does false mean? The opposite of true?
```

Since PHP doesn't support named arguments, the values of the flags are meaningless, and each time we come across a function call like the examples above, we have to search for the function definition. The code can be made more readable by using descriptive string values, instead of booleans.

```php
// Correct
function eat( $what, $speed = 'slowly' ) {
...
}
eat( 'mushrooms' );
eat( 'mushrooms', 'slowly' );
eat( 'dogfood', 'quickly' );
```

When more words are needed to describe the function parameters, an `$args` array may be a better pattern.

```php
// Even Better
function eat( $what, $args ) {
...
}
eat ( 'noodles', array( 'speed' => 'moderate' ) );
```

### Ternary Operator

Ternary operators are fine, but always have them test if the statement is true, not false. Otherwise, it just gets confusing. (An exception would be using `! empty()`, as testing for false here is generally more intuitive.)

The short ternary operator must not be used.

For example:

```php
// correct
$musictype = ( 'jazz' === $music ) ? 'cool' : 'blah';
$musictype = $music === 'jazz' ? 'cool' : 'blah';
// incorrect
$musictype = $music ?: 'blah';
```

### Yoda Conditions

```php
if ( true === $the_force ) {
	$victorious = you_will( $be );
}
```

When doing logical comparisons involving variables, always put the variable on the right side and put constants, literals, or function calls on the left side. If neither side is a variable, the order is not important. (In <a href="https://en.wikipedia.org/wiki/Value_(computer_science)#Assignment:_l-values_and_r-values">computer science terms</a>, in comparisons always try to put l-values on the right and r-values on the left.)

In the above example, if you omit an equals sign (admit it, it happens even to the most seasoned of us), you'll get a parse error, because you can't assign to a constant like `true`. If the statement were the other way around `( $the_force = true )`, the assignment would be perfectly valid, returning `1`, causing the if statement to evaluate to `true`, and you could be chasing that bug for a while.

This applies to ==, != , ===, and !==. Yoda conditions for &lt;, &gt;, &lt;= or &gt;= are significantly more difficult to read and are best avoided.

### Clever Code

In general, readability is more important than cleverness or brevity.

```php
isset( $var ) || $var = some_function();
```

Although the above line is clever, it takes a while to grok if you're not familiar with it. So, just write it like this:

```php
if ( ! isset( $var ) ) {
	$var = some_function();
}
```

Unless absolutely necessary, loose comparisons should not be used, as their behavior can be misleading.

Correct:

```php
if ( 0 === strpos( 'WordPress', 'foo' ) ) {
	echo __( 'Yay WordPress!' );
}
```

Incorrect:

```php
if ( 0 == strpos( 'WordPress', 'foo' ) ) {
	echo __( 'Yay WordPress!' );
}
```

Assignments must not be placed in conditionals.

Correct:

```php
$data = $wpdb->get_var( '...' );

if ( $data ) {
    // Use $data
}
```

Incorrect:

```php
if ( $data = $wpdb->get_var( '...' ) ) {
    // Use $data
}
```

In a `switch` statement, it's okay to have multiple empty cases fall through to a common block. If a case contains a block, then falls through to the next block, however, this must be explicitly commented.

```php
switch ( $foo ) {
	case 'bar':	      // Correct, an empty case can fall through without comment.
	case 'baz':
		echo $foo;    // Incorrect, a case with a block must break, return, or have a comment.
	case 'cat':
		echo 'mouse';
		break;        // Correct, a case with a break does not require a comment.
	case 'dog':
		echo 'horse';
		// no break   // Correct, a case can have a comment to explicitly mention the fall through.
	case 'fish':
		echo 'bird';
		break;
}
```

The `goto` statement must never be used.

The `eval()` construct is **very dangerous**, and is impossible to secure. Additionally, the `create_function()` function, which internally performs an `eval()`, is deprecated in PHP 7.2. Both of these must not be used.

## Credits

-   PHP standards: <a href="http://pear.php.net/manual/en/standards.php" target="_blank">Pear standards</a>
