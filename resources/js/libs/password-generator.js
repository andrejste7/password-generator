export default class PasswordGenerator {
    /**
     * @param {object} args options for password generator
     * @param {string} args.generatorUri uri for generating password
     * @param {string} args.passwordGeneratorFormId id of password generator form
     * @param {string} args.generateElementId element to bind generating click on
     * @param {string} args.outputElementId element to bind generated password output to
     */
    constructor(args = {}) {
        if (this.hasValidationError(args)) {
            return
        }

        this.generatorUri = args.generatorUri
        this.passwordGeneratorForm = $(`#${args.passwordGeneratorFormId}`)
        this.generateElement = $(`#${args.generateElementId}`)
        this.outputElement = $(`#${args.outputElementId}`)

        this.initializeEvents()
    }

    initializeEvents() {
        this.generateElement.on('click', () => {
            $.ajax({
                url: this.generatorUri,
                type: "post",
                data: this.passwordGeneratorForm.serialize()
            })
                .done((response) => {
                  if (response.success) {
                    this.outputElement.addClass('active')
                    this.outputElement.text(response.password)
                  } else {
                      $.each(response.error_list, function (key, error) {
                          alert(`[${key}] ${error}`)
                      })
                  }
                })
                .fail((jqXHR, ajaxOptions, thrownError) => {
                    alert('No response from server')
                })
        })

        this.outputElement.on('click', (e) => {
            let textToCopy = $(e.currentTarget).text()
            navigator.clipboard.writeText(textToCopy)
                .then(() => {
                    $(e.currentTarget).addClass('copied')
                    setTimeout(() => {
                        $(e.currentTarget).removeClass('copied')
                    }, 800)
                })
        })
    }

    hasValidationError(args = {}) {
        if (args.length <= 0) {
            alert('No arguments supplied for password generator')
            return false
        }

        let hasValidationError = false

        if (!args.hasOwnProperty('generatorUri')) {
            alert('argument "generatorUri" must be present on argument list')
            hasValidationError = true
        }

        if (!args.hasOwnProperty('passwordGeneratorFormId')) {
            alert('argument "passwordGeneratorFormId" must be present on argument list')
            hasValidationError = true
        }

        if (!args.hasOwnProperty('generateElementId')) {
            alert('argument "generateElementId" must be present on argument list')
            hasValidationError = true
        }

        if (!args.hasOwnProperty('outputElementId')) {
            alert('argument "outputElementId" must be present on argument list')
            hasValidationError = true
        }

        return hasValidationError
    }
}
