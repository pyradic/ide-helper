## FormBuilder:

- [Options](#options)
- [Callbacks](#callbacks)
- [Events](#events)
- [Call Sequence](#call-sequence)
- [Commands](#commands)
- [Component Builders](#component-builders)
- [Hints, Tips & tricks](#hints-tips--tricks)
- [Examples](#examples)



## Options
### Fields
todo...

### Sections
todo...

### Actions
todo...

### Buttons
pre-defined buttons can be found in the `ButtonRegistry` class.
```php
protected $buttons = [
    'cancel',     // pre-defined button, check ButtonRegistry
    'delete' => [ // you can override or append options for pre-defined buttons 
        'icon' => 'file-o' 
    ],
    '<slug>' => [
        'slug'        => 'blocks',
        'data-toggle' => 'modal',
        'data-toggle' => 'confirm',
        'data-toggle' => 'process',

        'data-icon' => 'info',
        'data-icon' => 'warning',

        'data-target' => '#modal',
        'data-href'   => 'admin/blocks/areas/{request.route.parameters.area}',

        'data-title'   => 'anomaly.module.addons::confirm.disable_title',
        'data-message' => 'anomaly.module.addons::confirm.disable_message',
        'data-message' => 'Updating Repositories',

        'button' => 'Fully\\Qualified\\Namespace\\CustomButtonClass',

        'type'       => 'warning',
        'icon'       => 'fa fa-toggle-off',
        'text'       => '',
        'permission' => '',
        'href'       => 'admin/addons/disable/{entry.namespace}',
        'attributes' => [
            'aria-foo' => 'something'
        ],
        
        'enabled' => 'admin/dashboard/view/*',
        'href'    => 'admin/blocks/areas/{request.route.parameters.area}/choose',       
    ],
];

```




## Callbacks
| Name                    | Fires From                 | Fires On                            |
|:--------------------------|:-----------------------------|:--------------------------------------|
| validating              |                            |  FormValidator                      |
| validated               |                            |  FormValidator                      |
| ready                   |                            |  FormBuilder                        |
| built                   |                            |  FormBuilder                        |
| make                    |                            |  FormBuilder                        |
| post                    |                            |  FormBuilder                        |
| posting                 |                            |  PostForm                           |
| posted                  |                            |  PostForm                           |
| saving                  |                            |  SaveForm                           |
| saved                   |                            |  SaveForm                           |
| setting_entry           | SetFormEntry               |  FormBuilder                        |
| entry_set               | SetFormEntry               | FormBuilder                         |

## Events
| Name                | Location |
|:----------------------|:-----------|
| FormWasBuilt        |            |
| FormWasPosted       |            |
| FormWasSaved        | SaveForm |
| FormWasValidated    |            |



## Call sequence

> Clicking the links scrolls to the documentation for it. Does not navigate you away from the page.


- `FormBuilder::build()`
  - **`CALLBACK`** `ready`
  - **`.COMMAND`** [`BuildForm`](#call-sequence) `..`
    - **`.COMMAND`** [`AddAssets`](#call-sequence) <small>`add assets to form`</small>
    - **`.COMMAND`** [`SetFormModel`](#call-sequence) `Resolve & set form model on both Form and FormBuilder`
    - **`.COMMAND`** [`SetFormStream`](#call-sequence) `Get stream from model and set it on Form `
    - **`.COMMAND`** [`SetRepository`](#call-sequence) `If not set, attempts to set correct FormRepository`
    - **`.COMMAND`** [`SetFormEntry`](#call-sequence) `Get entry on edit/create entry on create and set it on Form`
      - **`CALLBACK`** `setting_entry`
      - **`CALLBACK`** `entry_set`
    - **`.COMMAND`** [`SetFormVersion`](#call-sequence) `..`
    - **`.COMMAND`** [`SetDefaultParameters`](#call-sequence) `Copies some properties from FormBuilder to Form`
    - **`.COMMAND`** [`SetFormOptions`](#call-sequence) `Gets the FormBuilder options, transforms it and set in Form`
    - **`.COMMAND`** [`SetDefaultOptions`](#call-sequence) `Set missing options using default values on Form`
    - **`.COMMAND`** [`LoadFormErrors`](#call-sequence) `Load form errors from session and set on Form`
    - **`.COMMAND`** [`AuthorizeForm`](#call-sequence) `Uses the permissions option to authorize`
    - **`.COMMAND`** [`LockFormModel`](#call-sequence) `..`
    - **`.COMMAND`** [`BuildFields`](#call-sequence) `Transforms the FormBuilder fields array items to Field instances and adds it to Form`
      - [`FieldBuilder::build()`](#buildfields) `..`
        - [`FieldInput::read()`](#buildfields) `..`
          - **`.COMMAND`** [`FieldResolver`](#resolver) `..`
          - **`.COMMAND`** [`FieldNormalizer`](#normalizer) `..`
          - **`.COMMAND`** [`FieldEvaluator`](#evaluator) `..`
          - **`.COMMAND`** [`FieldDefaults`](#defaults) `..`
          - **`.COMMAND`** [`FieldFiller`](#filler) `..`
          - **`.COMMAND`** [`FieldNormalizer`](#normalizer) `..`
          - **`.COMMAND`** [`FieldGuesser`](#guesser) `..`
            - [`LabelsGuesser::guess()`](#guesser) `..`
            - [`UniqueGuesser::guess()`](#guesser) `..`
            - [`EnabledGuesser::guess()`](#guesser) `..`
            - [`WarningsGuesser::guess()`](#guesser) `..`
            - [`PrefixesGuesser::guess()`](#guesser) `..`
            - [`RequiredGuesser::guess()`](#guesser) `..`
            - [`NullableGuesser::guess()`](#guesser) `..`
            - [`DisabledGuesser::guess()`](#guesser) `..`
            - [`ReadOnlyGuesser::guess()`](#guesser) `..`
            - [`TranslatableGuesser::guess()`](#guesser) `..`
            - [`InstructionsGuesser::guess()`](#guesser) `..`
            - [`PlaceholdersGuesser::guess()`](#guesser) `..`
          - **`.COMMAND`** [`FieldParser`](#parser) `..`
          - **`.COMMAND`** [`FieldTranslator`](#translator) `..`
          - **`.COMMAND`** [`FieldPopulator`](#populator) `..`
        - [`FieldFactory::make()`](#buildfields) `..`
        - [`FormBuilder::addFormField()`](#buildfields) `..`
    - **`.COMMAND`** [`BuildSections`](#call-sequence) `Transforms the FormBuilder sections array and adds it to Form`
      - [`SectionBuilder::build()`](#buildsections) `..`
        - **`.COMMAND`** [`SectionResolver`](#resolver) `..`
        - **`.COMMAND`** [`SectionNormalizer`](#normalizer) `..`
        - **`.COMMAND`** [`SectionEvaluator`](#evaluator) `..`
    - **`.COMMAND`** [`BuildActions`](#call-sequence)
      - [`ActionBuilder::build()`](#buildactions) `..`
        - **`.COMMAND`** [`ActionResolver`](#resolver) `..`
        - **`.COMMAND`** [`ActionDefaults`](#defaults) `..`
        - **`.COMMAND`** [`ActionPredictor`](#predictor) `..`
        - **`.COMMAND`** [`ActionNormalizer`](#normalizer) `..`
        - **`.COMMAND`** [`ActionDropdown`](#dropdown) `..`
        - **`.COMMAND`** [`ActionGuesser`](#guesser) `..`
        - **`.COMMAND`** [`ActionLookup`](#lookup) `..`
        - **`.COMMAND`** [`ActionParser`](#parser) `..`
        - **`.COMMAND`** [`ActionDropdown`](#dropdown) `..`
        - **`.COMMAND`** [`ActionTranslator`](#translator) `..`
    - **`.COMMAND`** [`SetActiveAction`](#call-sequence)
    - **`.COMMAND`** [`BuildButtons`](#call-sequence) `...`
      - [`ButtonBuilder::build()`](#buildbuttons) `..`
        - **`.COMMAND`** [`ButtonResolver`](#resolver) `..`
        - **`.COMMAND`** [`ButtonEvaluator`](#evaluator) `..`
        - **`.COMMAND`** [`ButtonDefaults`](#defaults) `..`
        - **`.COMMAND`** [`ButtonNormalizer`](#normalizer) `..`
        - **`.COMMAND`** [`ButtonDropdown`](#dropdown) `..`
        - **`.COMMAND`** [`ButtonLookup`](#lookup) `..`
        - **`.COMMAND`** [`ButtonGuesser`](#guesser) `..`
        - **`.COMMAND`** [`ButtonParser`](#parser) `..`
        - **`.COMMAND`** [`ButtonDropdown`](#dropdown) `..`
    - **`...EVENT`** **FormWasBuilt**
    - **`CALLBACK`** `BuildButtons`
- `FormBuilder::make()`
  - **`CALLBACK`** make
  - **`.COMMAND`** [`LoadForm`](#call-sequence) `..`
  - **`.COMMAND`** [`MakeForm`](#call-sequence) `..`
- `FormBuilder::post()`
  - **`CALLBACK`** post
  - **`.COMMAND`** [`PostForm`](#call-sequence) `..`
    - **`CALLBACK`** posting
    - **`.COMMAND`** [`LoadFormValues`](#call-sequence) `..`
    - **`.COMMAND`** [`RemoveSkippedFields`](#call-sequence) `..`
    - **`.COMMAND`** [`HandleForm`](#call-sequence) `..`
    - **`.COMMAND`** [`SetSuccessMessage`](#call-sequence) `..`
    - **`.COMMAND`** [`HandleVersioning`](#call-sequence) `..`
    - **`.COMMAND`** [`SetActionResponse`](#call-sequence) `..`
    - **`.COMMAND`** [`SetJsonResponse`](#call-sequence) `..`
    - **`CALLBACK`** posted
    - **`...EVENT`** **FormWasPosted**
- `FormBuilder::validate()`
  - **`CALLBACK`** validating
  - **`.COMMAND`** [`ValidateForm`](#call-sequence) `..`
  - **`CALLBACK`** validated
  - **`...EVENT`** **FormWasValidated**
- `FormBuilder::flash()`
- `FormBuilder::render()`


## Commands
##### `SetFormModel`
Resolves the form module using ... and sets it on both the `Form` and `FormBuilder`
##### `SetFormStream`
Tries to set the stream by using the previously resolved form model using `$model->getStream)`
##### `SetRepository`
If not set, tries to set an appropriate `FormRepository` ([What is a FormRepository](#)).
- If exists, uses `<slug>FormRepository` next to this `<slug>FormBuilder`
- Otherwise use the `EntryFormRepository` when `form model` based on `EntryModel`
- Otherwise use the `EntryFormRepository` when `form model` based on `EloquentModel`

##### `SetFormEntry`
The `SetFormEntry` gets `$entry = $builder->getEntry()` which at this point is either `null` when creating a new entry or `$id` when editing an entry
 and calls the `FormRepository::findOrNew($entry)` to create and set the real entry model.

The `$id/$entry` is usually set in a `Controller` its `edit` function by calling `return $form->render($id);`
The `$form->render($id)` calls `$this->make($id)` calls `$this->build($id)` which calls

```
function build($entry){
    if ($entry) {
        $this->entry = $entry;
```


##### `SetFormVersion`
Switches the previously set Form Entry with another one? Haven't used this functionality yet..

##### `SetDefaultParameters`
Simple answer: Attempts to copy the `FormBuilder` properties to the `Form` using their getter & setter methods.
Long answer: tba...

##### `SetFormOptions`
Transfers the `FormBuilder->options` to the `Form->options`:
- Get `options` from `FormBuilder`
- Use [Resolver](#resolver) on `options` - For calling class handlers / callbacks
- Use [Evaluator](#evaluator) on `options` - For transforming string values containing `{builder.<name>}`. `builder` is the only available variable.
- Set `options` to `Form`


##### `SetDefaultOptions`
Sets the default `options` values for `form_view`, `wrapper_view` and `permissions`  on `Form` if they havent been set

##### `LoadFormErrors`
Loads the form errors from `session` and assigns it to the `Form`

##### `AuthorizeForm`
Uses the `Form $options['permissions']` to check authorisation

##### `LockFormModel`
If your application has locking enabled, this locks the model

##### `BuildFields`
- Takes the `FormBuilder->fields` array
- Throws it to the `FieldBuilder` that'll handle it
- Then the `FieldBuilder`
  - Runs it trough the `FieldInput->read()` method which calls all
    the Field Component Builders and Utilities in the correct order.
    Transforming the `FormBuilder->fields` array and finalizing it.
  - Calls the `FieldFactory` to create a `Field` class instance for each item in the `FormBuilder->fields` array
  - Adds created `Field` instances to the `Form`


##### `BuildSections`
- Takes the `FormBuilder->fields` array
- Throws it to the `SectionBuilder` that'll handle it
- Then the `SectionBuilder`
  - Runs it trough the `SectionInput->read()` method which only calls
    a `Resolver`,`Evaluator` and `Normalizer` on it.
  - It adds the result array to the `Form`

##### `BuildActions`
Set...
##### `SetActiveAction`
Set...
##### `BuildButtons`
Set...


**Interesting note:** The `ButtonFactory` checks for the `button` option in a `buttons` array item array and if set, uses it as class.

## Component Builders

### Resolver
Handler pattern that let's you defer the value or handling of something to a handler class.
Handlers is a generic term for a class that handles the value for an attribute that has an setter or mutator method like setFoo.
```php
// Where a typical attribute in an array might look like:
$array = [
    'example' => 'Test',
];
// A value handler for example might look like this:
$array = [
    'example' => \Example\TestHandler::class,
];
```

### Normalizer
A `Normalizer` will do something..

### Evaluator
The evaluate method evaluates a mixed value with the provided arguments.
```php
$entry = new Person(['name' =>'Ryan']);

# 1
$evaluator = app(\Anomaly\Streams\Platform\Support\Evaluator::class);
$evaluator->evaluate($target, $entry);

# 2: twig: {{ value($target, $entry) }}
# 3:
$evaluator->evaluate('{entry.name}', compact('entry'));

# 4:
$evaluator->evaluate(
    function($entry) {
        return $entry->name;
    },
    compact('entry')
); 
# 5:  {{ value('{entry.name}', entry) }}
```

### Defaults
A `Defaults` will do something..

### Filler
A `Filler` will do something..

### Guesser
A `Guesser` will do something..

### Parser
The Parser class is a simple service that parses data into a string. The parser leverages the (https://packagist.org/packages/nicmart/string-template) package.
The parse method recursively parses the target value with given data.

    $parser = app(Anomaly\Streams\Platform\Support\Parser::class);
    $parser->parse('Hello {user.first_name} {user.last_name}!', ['user' => Auth::user()]);


### Translator
A `Translator` will do something..

### Populator
A `Populator` will do something..


### Predictor
A `Populator` will do something..


### Lookup
A `Populator` will do something..


### Dropdown
A `Populator` will do something..


## Hints, Tips & tricks
todo..

## Examples
todo..

