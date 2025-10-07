#!/usr/bin/env node

/**
 * Close Plugin Scaffold CLI
 * 
 * @package     WordPress
 * @author      Closemarketing
 * @copyright   2025 Closemarketing
 * @license     GPL-2.0+
 */

const { Command } = require('commander');
const inquirer = require('inquirer');
const chalk = require('chalk');
const fs = require('fs-extra');
const path = require('path');
const ScaffoldGenerator = require('../lib/generator');
const LintGenerator = require('../lib/generator-lint');

const program = new Command();

program
  .name('close-scaffold')
  .description('Generate projects from Close Marketing scaffolds')
  .version('1.0.0');

// Command: create pluginwp
program
  .command('create')
  .description('Create a new project from a scaffold')
  .argument('<scaffold>', 'Scaffold type (pluginwp, themewp, etc.)')
  .option('-n, --name <name>', 'Project name')
  .option('-p, --prefix <prefix>', 'Prefix for functions')
  .option('-d, --description <description>', 'Project description')
  .option('-a, --author <author>', 'Project author')
  .option('-o, --output <path>', 'Output directory', './')
  .action(async (scaffold, options) => {
    try {
      // Validate scaffold type
      const validScaffolds = ['pluginwp', 'lint'];
      if (!validScaffolds.includes(scaffold)) {
        console.error(chalk.red(`❌ Invalid scaffold type: ${scaffold}`));
        console.log(chalk.yellow('Available scaffolds:'));
        validScaffolds.forEach(s => console.log(chalk.white(`  - ${s}`)));
        process.exit(1);
      }

      let generator;
      if (scaffold === 'lint') {
        generator = new LintGenerator('lint');
      } else {
        generator = new ScaffoldGenerator(scaffold);
      }
      
      // Si no se proporcionan opciones, usar modo interactivo
      if (!options.name) {
        const answers = await inquirer.prompt([
          {
            type: 'input',
            name: 'name',
            message: scaffold === 'lint' ? 'Project name:' : 'Plugin name:',
            validate: (input) => {
              if (!input.trim()) {
                return 'Name is required';
              }
              return true;
            }
          },
          {
            type: 'input',
            name: 'description',
            message: scaffold === 'lint' ? 'Project description:' : 'Plugin description:',
            default: 'Plugin description'
          },
          {
            type: 'input',
            name: 'author',
            message: 'Author:',
            default: 'Closemarketing'
          },
          {
            type: 'input',
            name: 'output',
            message: 'Output directory:',
            default: './'
          }
        ]);
        
        Object.assign(options, answers);
      }
      
      const scaffoldName = scaffold === 'pluginwp' ? 'WordPress plugin' : (scaffold === 'lint' ? 'Lint (PHPStan) files' : scaffold);
      console.log(chalk.blue(`🚀 Generating ${scaffoldName}...`));
      
      await generator.generate(options);
      
      console.log(chalk.green(`✅ ${scaffoldName} generated successfully!`));
      console.log(chalk.yellow(`📁 Location: ${path.resolve(options.output)}`));
      
    } catch (error) {
      console.error(chalk.red('❌ Error generating project:'), error.message);
      process.exit(1);
    }
  });

// Command: list - Show available scaffolds
program
  .command('list')
  .description('List available scaffolds')
  .action(() => {
    console.log(chalk.blue('📦 Available scaffolds:\n'));
    console.log(chalk.white('  pluginwp') + chalk.gray('     - WordPress plugin with custom post types, theme integration'));
    console.log(chalk.white('  lint') + chalk.gray('         - PHPStan config scaffold'));
    console.log(chalk.gray('  themewp      - WordPress theme (coming soon)'));
    console.log(chalk.gray('  block        - Gutenberg block (coming soon)'));
    console.log(chalk.gray('  react-app    - React application (coming soon)'));
    console.log(chalk.white('\nUsage: ') + chalk.cyan('close-scaffold create <scaffold>'));
  });

program.parse();
