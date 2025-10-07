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
      const validScaffolds = ['pluginwp'];
      if (!validScaffolds.includes(scaffold)) {
        console.error(chalk.red(`❌ Invalid scaffold type: ${scaffold}`));
        console.log(chalk.yellow('Available scaffolds:'));
        validScaffolds.forEach(s => console.log(chalk.white(`  - ${s}`)));
        process.exit(1);
      }

      const generator = new ScaffoldGenerator(scaffold);
      
      // Si no se proporcionan opciones, usar modo interactivo
      if (!options.name) {
        const answers = await inquirer.prompt([
          {
            type: 'input',
            name: 'name',
            message: 'Plugin name:',
            validate: (input) => {
              if (!input.trim()) {
                return 'Plugin name is required';
              }
              return true;
            }
          },
          {
            type: 'input',
            name: 'description',
            message: 'Plugin description:',
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
            name: 'prefix',
            message: 'Plugin prefix (for functions):',
            validate: (input) => {
              if (!input.trim()) {
                return 'Plugin prefix is required';
              }
              if (!/^[a-z_]+$/.test(input)) {
                return 'Prefix must contain only lowercase letters and underscores';
              }
              return true;
            }
          },
          {
            type: 'input',
            name: 'output',
            message: 'Output directory:',
            default: './'
          },
          {
            type: 'checkbox',
            name: 'features',
            message: 'Select features to include:',
            choices: [
              { name: 'Custom Post Types', value: 'post-types', checked: true },
              { name: 'Custom Login', value: 'custom-login', checked: true },
              { name: 'Theme Integration', value: 'theme', checked: true },
              { name: 'WooCommerce Integration', value: 'woocommerce', checked: false },
              { name: 'Blocks', value: 'blocks', checked: false },
              { name: 'Shortcodes', value: 'shortcodes', checked: false }
            ]
          }
        ]);
        
        Object.assign(options, answers);
      }
      
      const scaffoldName = scaffold === 'pluginwp' ? 'WordPress plugin' : scaffold;
      console.log(chalk.blue(`🚀 Generating ${scaffoldName}...`));
      
      await generator.generate(options);
      
      console.log(chalk.green(`✅ ${scaffoldName} generated successfully!`));
      console.log(chalk.yellow(`📁 Location: ${path.resolve(options.output, options.name.toLowerCase().replace(/\s+/g, '-'))}`));
      
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
    console.log(chalk.gray('  themewp      - WordPress theme (coming soon)'));
    console.log(chalk.gray('  block        - Gutenberg block (coming soon)'));
    console.log(chalk.gray('  react-app    - React application (coming soon)'));
    console.log(chalk.white('\nUsage: ') + chalk.cyan('close-scaffold create <scaffold>'));
  });

program.parse();
