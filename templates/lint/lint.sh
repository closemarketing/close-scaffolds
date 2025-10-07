#!/bin/bash

###
# Lint Script for {{PLUGIN_NAME}}
# 
# @package     {{PLUGIN_NAME}}
# @author      {{PLUGIN_AUTHOR}}
# @copyright   {{CURRENT_YEAR}} Closemarketing
# @license     GPL-2.0+
###

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Check if vendor directory exists
if [ ! -d "vendor" ]; then
    echo -e "${RED}Error: vendor directory not found${NC}"
    echo -e "${YELLOW}Please run: composer install${NC}"
    exit 1
fi

# Function to run PHPCS
run_phpcs() {
    echo -e "${BLUE}Running PHP_CodeSniffer...${NC}"
    if composer phpcs; then
        echo -e "${GREEN}✓ PHPCS: No coding standard violations found${NC}"
        return 0
    else
        echo -e "${RED}✗ PHPCS: Found coding standard violations${NC}"
        echo -e "${YELLOW}Run 'composer lint:fix' to auto-fix some issues${NC}"
        return 1
    fi
}

# Function to run PHPStan
run_phpstan() {
    echo -e "${BLUE}Running PHPStan...${NC}"
    if composer phpstan; then
        echo -e "${GREEN}✓ PHPStan: No errors found${NC}"
        return 0
    else
        echo -e "${RED}✗ PHPStan: Found errors${NC}"
        return 1
    fi
}

# Function to fix coding standards
fix_code() {
    echo -e "${BLUE}Running PHP Code Beautifier and Fixer...${NC}"
    composer phpcbf || true
    echo -e "${GREEN}✓ Auto-fix completed${NC}"
    echo -e "${YELLOW}Please review the changes and run lint again${NC}"
}

# Parse arguments
case "${1:-lint}" in
    phpcs)
        run_phpcs
        ;;
    phpstan)
        run_phpstan
        ;;
    fix)
        fix_code
        ;;
    lint|all)
        echo -e "${BLUE}========================================${NC}"
        echo -e "${BLUE}  Running all linting tools${NC}"
        echo -e "${BLUE}========================================${NC}"
        echo ""
        
        PHPCS_RESULT=0
        PHPSTAN_RESULT=0
        
        run_phpcs || PHPCS_RESULT=$?
        echo ""
        run_phpstan || PHPSTAN_RESULT=$?
        
        echo ""
        echo -e "${BLUE}========================================${NC}"
        
        if [ $PHPCS_RESULT -eq 0 ] && [ $PHPSTAN_RESULT -eq 0 ]; then
            echo -e "${GREEN}✓ All linting checks passed!${NC}"
            exit 0
        else
            echo -e "${RED}✗ Some linting checks failed${NC}"
            exit 1
        fi
        ;;
    *)
        echo "Usage: $0 {lint|phpcs|phpstan|fix}"
        echo ""
        echo "Commands:"
        echo "  lint     - Run all linting tools (default)"
        echo "  phpcs    - Run PHP_CodeSniffer only"
        echo "  phpstan  - Run PHPStan only"
        echo "  fix      - Auto-fix coding standard violations"
        exit 1
        ;;
esac
