const fs = require('fs-extra');
const path = require('path');
const chalk = require('chalk');

class LintGenerator {
  constructor(scaffoldType = 'lint') {
    this.scaffoldType = scaffoldType;
    this.sourceDir = path.join(__dirname, `../templates/${scaffoldType}`);
  }

  async generate(options) {
    const { name, description, author, output } = options;

    if (!name || !name.trim()) {
      throw new Error('Project name is required');
    }

    const templateData = this.prepareTemplateData(options);

    const outputDir = path.resolve(output);

    if (await fs.pathExists(outputDir)) {
      const files = await fs.readdir(outputDir);
      if (files.length > 0) {
        throw new Error(`Output directory ${outputDir} is not empty. Please use an empty directory.`);
      }
    }

    await fs.ensureDir(outputDir);

    // Copy PHPStan files
    const composerSrc = path.join(this.sourceDir, 'composer.json');
    const phpstanConfigSrc = path.join(this.sourceDir, 'phpstan.neon.dist');

    console.log(chalk.blue('🔍 Adding PHPStan configuration...'));

    if (await fs.pathExists(composerSrc)) {
      await this.copyAndProcessFile(composerSrc, path.join(outputDir, 'composer.json'), templateData);
    } else {
      console.log(chalk.yellow('⚠️  composer.json template not found, skipping'));
    }

    if (await fs.pathExists(phpstanConfigSrc)) {
      await this.copyAndProcessFile(phpstanConfigSrc, path.join(outputDir, 'phpstan.neon.dist'), templateData);
    } else {
      console.log(chalk.yellow('⚠️  phpstan.neon.dist template not found, skipping'));
    }

    console.log(chalk.green(`✅ Lint files for "${name}" created successfully!`));
    console.log(chalk.blue(`📁 Location: ${outputDir}`));
    console.log(chalk.yellow('🔧 Next steps:'));
    console.log(chalk.white('   1. Run composer install'));
    console.log(chalk.white('   2. Run composer phpstan'));
  }

  prepareTemplateData(options) {
    const { name, description, author } = options;
    const pluginSlug = name.toLowerCase().replace(/\s+/g, '-');

    return {
      PLUGIN_NAME: name,
      PLUGIN_DESCRIPTION: description,
      PLUGIN_AUTHOR: author,
      PLUGIN_SLUG: pluginSlug,
      TEXT_DOMAIN: pluginSlug.replace(/-/g, ''),
      CURRENT_YEAR: new Date().getFullYear(),
      VERSION: '1.0.0'
    };
  }

  async copyAndProcessFile(srcPath, destPath, templateData) {
    let content = await fs.readFile(srcPath, 'utf8');
    for (const [key, value] of Object.entries(templateData)) {
      const regex = new RegExp(`{{${key}}}`, 'g');
      content = content.replace(regex, value);
    }
    await fs.writeFile(destPath, content);
  }
}

module.exports = LintGenerator;
