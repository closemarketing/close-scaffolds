/**
 * Scaffold Generator Class
 * 
 * @package     WordPress
 * @author      Closemarketing
 * @copyright   2025 Closemarketing
 * @license     GPL-2.0+
 */

const fs = require('fs-extra');
const path = require('path');
const chalk = require('chalk');

class ScaffoldGenerator {
  constructor(scaffoldType = 'pluginwp') {
    this.scaffoldType = scaffoldType;
    this.templateDir = path.join(__dirname, '../templates');
    this.sourceDir = path.join(__dirname, `../templates/${scaffoldType}`);
  }

  /**
   * Generate plugin from template
   * 
   * @param {Object} options - Generation options
   * @return {Promise<void>}
   */
  async generate(options) {
    const {
      name,
      description,
      author,
      prefix,
      output,
      features = ['post-types', 'custom-login', 'theme']
    } = options;

    // Validate inputs
    this.validateOptions(options);

    // Prepare template data
    const templateData = this.prepareTemplateData(options);

    // Create output directory
    const pluginSlug = name.toLowerCase().replace(/\s+/g, '-');
    const outputDir = path.resolve(output, pluginSlug);
    
    if (await fs.pathExists(outputDir)) {
      throw new Error(`Directory ${outputDir} already exists`);
    }

    await fs.ensureDir(outputDir);

    // Copy and process files
    await this.copyTemplateFiles(outputDir, templateData, features);

    console.log(chalk.green(`✅ Plugin "${name}" created successfully!`));
    console.log(chalk.blue(`📁 Location: ${outputDir}`));
    console.log(chalk.yellow('🔧 Next steps:'));
    console.log(chalk.white('   1. Copy the plugin folder to your WordPress plugins directory'));
    console.log(chalk.white('   2. Activate the plugin in WordPress admin'));
    console.log(chalk.white('   3. Customize the code as needed'));
  }

  /**
   * Validate generation options
   * 
   * @param {Object} options - Options to validate
   * @return {void}
   */
  validateOptions(options) {
    const { name, prefix } = options;

    if (!name || !name.trim()) {
      throw new Error('Plugin name is required');
    }

    if (!prefix || !prefix.trim()) {
      throw new Error('Plugin prefix is required');
    }

    if (!/^[a-z_]+$/.test(prefix)) {
      throw new Error('Prefix must contain only lowercase letters and underscores');
    }
  }

  /**
   * Prepare template data for replacement
   * 
   * @param {Object} options - Generation options
   * @return {Object} Template data
   */
  prepareTemplateData(options) {
    const { name, description, author, prefix } = options;
    
    // Generate constants from name
    const constantName = name.toUpperCase().replace(/[^A-Z0-9]/g, '_');
    const pluginSlug = name.toLowerCase().replace(/\s+/g, '-');
    const className = name.replace(/[^A-Za-z0-9]/g, '');
    
    return {
      // Plugin info
      PLUGIN_NAME: name,
      PLUGIN_DESCRIPTION: description,
      PLUGIN_AUTHOR: author,
      PLUGIN_SLUG: pluginSlug,
      
      // Code identifiers
      PREFIX: prefix,
      CONSTANT_NAME: constantName,
      CLASS_NAME: className,
      
      // Text domain
      TEXT_DOMAIN: pluginSlug.replace(/-/g, ''),
      
      // Current year
      CURRENT_YEAR: new Date().getFullYear(),
      
      // Version
      VERSION: '1.0.0'
    };
  }

  /**
   * Copy and process template files
   * 
   * @param {string} outputDir - Output directory
   * @param {Object} templateData - Template replacement data
   * @param {Array} features - Features to include
   * @return {Promise<void>}
   */
  async copyTemplateFiles(outputDir, templateData, features) {
    console.log(chalk.blue('📄 Copying main plugin file...'));
    
    // Copy main plugin file from source directory
    const pluginPath = path.join(this.sourceDir, 'plugin.php');
    
    if (!await fs.pathExists(pluginPath)) {
      throw new Error('plugin.php template not found in templates/pluginwp/');
    }
    
    await this.copyAndProcessFile(
      pluginPath,
      path.join(outputDir, 'plugin.php'),
      templateData
    );

    console.log(chalk.blue('📄 Copying readme.txt...'));
    
    // Copy readme.txt from source directory
    const readmePath = path.join(this.sourceDir, 'readme.txt');
    
    if (await fs.pathExists(readmePath)) {
      await this.copyAndProcessFile(
        readmePath,
        path.join(outputDir, 'readme.txt'),
        templateData
      );
    } else {
      console.log(chalk.yellow('⚠️  readme.txt not found, skipping'));
    }

    console.log(chalk.blue('📁 Copying includes directory...'));
    
    // Copy includes directory structure
    await this.copyIncludesDirectory(outputDir, templateData, features);
  }

  /**
   * Copy includes directory with feature filtering
   * 
   * @param {string} outputDir - Output directory
   * @param {Object} templateData - Template replacement data
   * @param {Array} features - Features to include
   * @return {Promise<void>}
   */
  async copyIncludesDirectory(outputDir, templateData, features) {
    const includesDir = path.join(outputDir, 'includes');
    await fs.ensureDir(includesDir);

    // Always copy custom-login if selected
    if (features.includes('custom-login')) {
      await this.copyDirectory(
        path.join(this.sourceDir, 'includes/custom-login'),
        path.join(includesDir, 'custom-login'),
        templateData
      );
    }

    // Copy post-types if selected
    if (features.includes('post-types')) {
      await this.copyDirectory(
        path.join(this.sourceDir, 'includes/post-types'),
        path.join(includesDir, 'post-types'),
        templateData
      );
    }

    // Copy theme if selected
    if (features.includes('theme')) {
      await this.copyDirectory(
        path.join(this.sourceDir, 'includes/theme'),
        path.join(includesDir, 'theme'),
        templateData
      );
    }

    // Copy woocommerce if selected
    if (features.includes('woocommerce')) {
      await this.copyDirectory(
        path.join(this.sourceDir, 'includes/woocommerce'),
        path.join(includesDir, 'woocommerce'),
        templateData
      );
    }

    // Copy blocks if selected
    if (features.includes('blocks')) {
      await this.copyDirectory(
        path.join(this.sourceDir, 'includes/blocks'),
        path.join(includesDir, 'blocks'),
        templateData
      );
    }

    // Copy shortcodes if selected
    if (features.includes('shortcodes')) {
      await this.copyDirectory(
        path.join(this.sourceDir, 'includes/shortcodes'),
        path.join(includesDir, 'shortcodes'),
        templateData
      );
    }
  }

  /**
   * Copy directory and process files
   * 
   * @param {string} srcDir - Source directory
   * @param {string} destDir - Destination directory
   * @param {Object} templateData - Template replacement data
   * @return {Promise<void>}
   */
  async copyDirectory(srcDir, destDir, templateData) {
    if (!await fs.pathExists(srcDir)) {
      return;
    }

    await fs.ensureDir(destDir);
    
    const files = await fs.readdir(srcDir);
    
    for (const file of files) {
      const srcPath = path.join(srcDir, file);
      const destPath = path.join(destDir, file);
      
      const stat = await fs.stat(srcPath);
      
      if (stat.isDirectory()) {
        await this.copyDirectory(srcPath, destPath, templateData);
      } else {
        await this.copyAndProcessFile(srcPath, destPath, templateData);
      }
    }
  }

  /**
   * Copy and process a single file
   * 
   * @param {string} srcPath - Source file path
   * @param {string} destPath - Destination file path
   * @param {Object} templateData - Template replacement data
   * @return {Promise<void>}
   */
  async copyAndProcessFile(srcPath, destPath, templateData) {
    if (!await fs.pathExists(srcPath)) {
      console.log(chalk.yellow(`⚠️  Skipping: ${srcPath} (not found)`));
      return;
    }

    try {
      // Check if it's a binary file
      const ext = path.extname(srcPath).toLowerCase();
      const binaryExtensions = ['.svg', '.png', '.jpg', '.jpeg', '.gif', '.ico', '.woff', '.woff2', '.ttf', '.eot'];
      
      if (binaryExtensions.includes(ext)) {
        // Copy binary file as-is
        await fs.copy(srcPath, destPath);
        return;
      }

      let content = await fs.readFile(srcPath, 'utf8');
      
      // Replace template variables ({{VARIABLE}})
      for (const [key, value] of Object.entries(templateData)) {
        const regex = new RegExp(`{{${key}}}`, 'g');
        content = content.replace(regex, value);
      }

      await fs.writeFile(destPath, content);
    } catch (error) {
      console.error(chalk.red(`❌ Error processing ${srcPath}:`), error.message);
      throw error;
    }
  }

}

module.exports = ScaffoldGenerator;

