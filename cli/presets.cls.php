<?php
/**
 * Presets CLI for Zinn® Cache Engine.
 *
 * @package ZinnCachePro\CLI
 */

namespace ZinnCachePro\CLI;

defined( 'WPINC' ) || exit();

use ZinnCachePro\Debug2;
use ZinnCachePro\Preset;
use WP_CLI;

/**
 * Presets CLI
 */
class Presets {

	/**
	 * Preset instance.
	 *
	 * @var Preset
	 */
	private $preset;

	/**
	 * Constructor for Presets CLI.
	 */
	public function __construct() {
		Debug2::debug( 'CLI_Presets init' );

		$this->preset = Preset::cls();
	}

	/**
	 * Applies a standard preset's settings.
	 *
	 * ## OPTIONS
	 *
	 * <preset>
	 * : The preset name to apply (e.g., basic).
	 *
	 * ## EXAMPLES
	 *
	 *     # Apply the preset called "basic"
	 *     $ wp zinn-cache-pro-presets apply basic
	 *
	 * @param array $args Positional arguments (preset).
	 */
	public function apply( $args ) {
		$preset = $args[0];

		if ( empty( $preset ) ) {
			WP_CLI::error( 'Please specify a preset to apply.' );
			return;
		}

		return $this->preset->apply( $preset );
	}

	/**
	 * Returns sorted backup names.
	 *
	 * ## OPTIONS
	 *
	 * ## EXAMPLES
	 *
	 *     # Get all backups
	 *     $ wp zinn-cache-pro-presets get_backups
	 */
	public function get_backups() {
		$backups = $this->preset->get_backups();

		foreach ( $backups as $backup ) {
			WP_CLI::line( $backup );
		}
	}

	/**
	 * Restores settings from the backup file with the given timestamp, then deletes the file.
	 *
	 * ## OPTIONS
	 *
	 * <timestamp>
	 * : The timestamp of the backup to restore.
	 *
	 * ## EXAMPLES
	 *
	 *     # Restore the backup with the timestamp 1667485245
	 *     $ wp zinn-cache-pro-presets restore 1667485245
	 *
	 * @param array $args Positional arguments (timestamp).
	 */
	public function restore( $args ) {
		$timestamp = $args[0];

		if ( empty( $timestamp ) ) {
			WP_CLI::error( 'Please specify a timestamp to restore.' );
			return;
		}

		return $this->preset->restore( $timestamp );
	}
}
