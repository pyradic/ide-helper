## FormBuilder:

- [Callbacks](form-builder.md)
- [Events](form-builder.md)
- [Call Sequence](form-builder.md)
- [Examples](form-builder.md)


### Callbacks
| Name                    | Location                      |
|:--------------------------|:--------------------------------|
| validating              | FormValidator                 |
| validated               | FormValidator                 |
| ready                   | FormBuilder                   |
| built                   | FormBuilder                   |
| make                    | FormBuilder                   |
| post                    | FormBuilder                   |
| posting                 | PostForm                      |
| posted                  | PostForm                      |
| saving                  | SaveForm                      |
| saved                   | SaveForm                      |
| setting_entry           |                               |
| entry_set               |                               |

### Events
| Name                | Location |
|:----------------------|:-----------|
| FormWasBuilt        |            |
| FormWasPosted       |            |
| FormWasSaved        | SaveForm |
| FormWasValidated    |            |


### Call sequence
- FormBuilder::build()
    - **`CALLBACK`** ready
    - **`.COMMAND`** BuildForm
        - **`.COMMAND`** [`AddAssets`](form-builder.md) <small>`add assets to form`</small>
        - **`.COMMAND`** [`SetFormModel`](form-builder.md) `..`
        - **`.COMMAND`** [`SetFormStream`](form-builder.md) `..`
        - **`.COMMAND`** [`SetRepository`](form-builder.md) `..`
        - **`.COMMAND`** [`SetFormEntry`](form-builder.md) `..`
        - **`.COMMAND`** [`SetFormVersion`](form-builder.md) `..`
        - **`.COMMAND`** [`SetDefaultParameters`](form-builder.md) `..`
        - **`.COMMAND`** [`SetFormOptions`](form-builder.md) `..`
        - **`.COMMAND`** [`SetDefaultOptions`](form-builder.md) `..`
        - **`.COMMAND`** [`LoadFormErrors`](form-builder.md) `..`
        - **`.COMMAND`** [`AuthorizeForm`](form-builder.md) `..`
        - **`.COMMAND`** [`LockFormModel`](form-builder.md) `..`
        - **`.COMMAND`** [`BuildFields`](form-builder.md) `..`
            - FieldBuilder::build()
                - **`.COMMAND`** [`FieldResolver`](#resolver) `..`
                - **`.COMMAND`** [`FieldNormalizer`](#normalizer) `..`
                - **`.COMMAND`** [`FieldEvaluator`](#evaluator) `..`
                - **`.COMMAND`** [`FieldDefaults`](#defaults) `..`
                - **`.COMMAND`** [`FieldFiller`](#filler) `..`
                - **`.COMMAND`** [`FieldNormalizer`](#normalizer) `..`
                - **`.COMMAND`** [`FieldGuesser`](#guesser) `..`
                    - [`LabelsGuesser::guess()`](form-builder.md) `..`
                    - [`UniqueGuesser::guess()`](form-builder.md) `..`
                    - [`EnabledGuesser::guess()`](form-builder.md) `..`
                    - [`WarningsGuesser::guess()`](form-builder.md) `..`
                    - [`PrefixesGuesser::guess()`](form-builder.md) `..`
                    - [`RequiredGuesser::guess()`](form-builder.md) `..`
                    - [`NullableGuesser::guess()`](form-builder.md) `..`
                    - [`DisabledGuesser::guess()`](form-builder.md) `..`
                    - [`ReadOnlyGuesser::guess()`](form-builder.md) `..`
                    - [`TranslatableGuesser::guess()`](form-builder.md) `..`
                    - [`InstructionsGuesser::guess()`](form-builder.md) `..`
                    - [`PlaceholdersGuesser::guess()`](form-builder.md) `..`
                - **`.COMMAND`** [`FieldParser`](form-builder.md) `..`
                - **`.COMMAND`** [`FieldTranslator`](form-builder.md) `..`
                - **`.COMMAND`** [`FieldPopulator`](form-builder.md) `..`
        - **`.COMMAND`** [`BuildSections`](form-builder.md)
        - **`.COMMAND`** [`BuildActions`](form-builder.md)
        - **`.COMMAND`** [`SetActiveAction`](form-builder.md)
        - **`.COMMAND`** [`BuildButtons`](form-builder.md) `...`
        - **`...EVENT`** FormWasBuilt
        - **`CALLBACK`** BuildButtons
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

## Concepts

#### Resolver
A `Resolver` will do something..

#### Normalizer
A `Normalizer` will do something..

#### Evaluator
A `Evaluator` will do something..

#### Defaults
A `Defaults` will do something..

#### Filler
A `Filler` will do something..

#### Guesser
A `Guesser` will do something..

#### Parser
A `Parser` will do something..

#### Translator
A `Translator` will do something..

#### Populator
A `Populator` will do something..

