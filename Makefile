COMMIT := $(shell git rev-parse --short=8 HEAD)
ZIP_FILENAME := $(or $(ZIP_FILENAME), $(shell echo "$${PWD\#\#*/}.zip"))
BUILD_DIR := $(or $(BUILD_DIR),build)
VENDOR_AUTOLOAD := endor/autoload.php
ZIP_FILE := build/sub.zip

ifeq ($(CI)x, x)
	COMPOSER_ARGS :=
else
	COMPOSER_ARGS :=
	ifeq ($(DEV)x, x)
		COMPOSER_ARGS := $(COMPOSER_ARGS) --no-dev
	endif
endif

help:  ## Print the help documentation
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

$(VENDOR_AUTOLOAD):
	composer install $(COMPOSER_ARGS)

$(ZIP_FILE): $(VENDOR_AUTOLOAD)
	git archive --format=zip --output=${ZIP_FILENAME} $(COMMIT)
	zip -r ${ZIP_FILENAME} vendor/
	mkdir ${BUILD_DIR} && mv ${ZIP_FILENAME} ${BUILD_DIR}/

.PHONY: build
build: $(ZIP_FILE)  ## Build

.PHONY: clean
clean:  ## clean
	rm -rf build

.PHONY: composer
composer: $(VENDOR_AUTOLOAD) ## Runs composer install

.PHONY: lint
lint: $(VENDOR_AUTOLOAD) ## PHP Lint
	vendor/squizlabs/php_codesniffer/bin/phpcs

.PHONY: lint-fix
lint-fix: $(VENDOR_AUTOLOAD) ## PHP Lint Fix
	vendor/squizlabs/php_codesniffer/bin/phpcbf
