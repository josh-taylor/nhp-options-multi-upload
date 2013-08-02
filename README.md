NHP Options - Multiple File Upload
==================================

A multiple file upload field for NHP Options.

It allows you to upload multiple images in one field and can be used like any other of the standard NHP Option fields.

## Installation

To install, just clone or download a tarball of this repository and copy the multi_upload directory into your `NHP_OPTIONS/fields` directory.

To add it as a field modify your 'fields' key in the section you want to add it to using the type `multi_upload`.

```php
$sections = [] = array(
	...
	'fields' => array(
		...
		array(
			'id' => 'my_multiple_upload_field',
			'type' => 'multi_upload',
			'title' => 'My multiple upload field'
		),
		...
	)
```

## Usage

To use inside your theme:

```php
global $NHP_Options;
$images = $NHP_Options->get('my_multiple_upload_field');

foreach ($images as $image) {
	echo "<img src='{$image}' />";
}
```
