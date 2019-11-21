## FormBuilder:

- [Callbacks](#callbacks)
- [Events](#events)
- [Call Sequence](#call-sequence)
- [Commands](#commands)
- [Component Builders](#component-builders)



### Options

### Callbacks
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

### Events
| Name                | Location |
|:----------------------|:-----------|
| FormWasBuilt        |            |
| FormWasPosted       |            |
| FormWasSaved        | SaveForm |
| FormWasValidated    |            |



### Call sequence

> Clicking the links scrolls to the documentation for it. Does not navigate you away from the page.

- `FormBuilder::build()`
  - **`CALLBACK`** `ready`
  - **`.COMMAND`** [`BuildForm`](form-builder.md) `..`
    - **`.COMMAND`** [`AddAssets`](form-builder.md) <small>`add assets to form`</small>
    - **`.COMMAND`** [`SetFormModel`](form-builder.md) `..`
    - **`.COMMAND`** [`SetFormStream`](form-builder.md) `..`
    - **`.COMMAND`** [`SetRepository`](form-builder.md) `..`
    - **`.COMMAND`** [`SetFormEntry`](form-builder.md) `..`
      - **`CALLBACK`** `setting_entry`
      - **`CALLBACK`** `entry_set`
    - **`.COMMAND`** [`SetFormVersion`](form-builder.md) `..`
    - **`.COMMAND`** [`SetDefaultParameters`](form-builder.md) `..`
    - **`.COMMAND`** [`SetFormOptions`](form-builder.md) `..`
    - **`.COMMAND`** [`SetDefaultOptions`](form-builder.md) `..`
    - **`.COMMAND`** [`LoadFormErrors`](form-builder.md) `..`
    - **`.COMMAND`** [`AuthorizeForm`](form-builder.md) `..`
    - **`.COMMAND`** [`LockFormModel`](form-builder.md) `..`
    - **`.COMMAND`** [`BuildFields`](form-builder.md) `..`
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
    - **`.COMMAND`** [`BuildSections`](form-builder.md)
      - [`SectionBuilder::build()`](#buildsections) `..`
        - **`.COMMAND`** [`SectionResolver`](#resolver) `..`
        - **`.COMMAND`** [`SectionNormalizer`](#normalizer) `..`
        - **`.COMMAND`** [`SectionEvaluator`](#evaluator) `..`
    - **`.COMMAND`** [`BuildActions`](form-builder.md)
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
    - **`.COMMAND`** [`SetActiveAction`](form-builder.md)
    - **`.COMMAND`** [`BuildButtons`](form-builder.md) `...`
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
    - **`...EVENT`** FormWasBuilt
    - **`CALLBACK`** `BuildButtons`
- FormBuilder::make()
  - **`CALLBACK`** make
  - **`.COMMAND`** LoadForm
  - **`.COMMAND`** MakeForm
- FormBuilder::post()
  - **`CALLBACK`** post
  - **`.COMMAND`** PostForm
    - **`CALLBACK`** posting
    - **`.COMMAND`** [`LoadFormValues`](form-builder.md) `..`
    - **`.COMMAND`** [`RemoveSkippedFields`](form-builder.md) `..`
    - **`.COMMAND`** [`HandleForm`](form-builder.md) `..`
    - **`.COMMAND`** [`SetSuccessMessage`](form-builder.md) `..`
    - **`.COMMAND`** [`HandleVersioning`](form-builder.md) `..`
    - **`.COMMAND`** [`SetActionResponse`](form-builder.md) `..`
    - **`.COMMAND`** [`SetJsonResponse`](form-builder.md) `..`
    - **`CALLBACK`** posted
    - **`...EVENT`** FormWasPosted
- FormBuilder::validate()
- FormBuilder::flash()
- FormBuilder::render()

## MultipleFormBuilder:

saving_{$slug}
saved_{$slug}
posting_forms
posting_{$slug}
versioning_forms
versioning_{$slug}

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


**Interesting note:** The `FieldFactory` checks for the `field` option in a `fields` array item and if set, uses it as class.

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

