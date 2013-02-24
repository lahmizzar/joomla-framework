<?php
/**
 * @package     Joomla.Platform
 * @subpackage  GitHub
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Github;

defined('JPATH_PLATFORM') or die;

use Joomla\Registry\Registry;

/**
 * Joomla Platform class for interacting with a GitHub server instance.
 *
 * @property-read  Gists       $gists       GitHub API object for gists.
 * @property-read  Issues      $issues      GitHub API object for issues.
 * @property-read  Pulls       $pulls       GitHub API object for pulls.
 * @property-read  Refs        $refs        GitHub API object for referencess.
 * @property-read  Forks       $forks       GitHub API object for forks.
 * @property-read  Commits     $commits     GitHub API object for commits.
 * @property-read  Milestones  $milestones  GitHub API object for commits.
 * @property-read  Statuses    $statuses    GitHub API object for commits.
 * @property-read  Account     $account     GitHub API object for account references.
 * @property-read  Hooks       $hooks       GitHub API object for hooks.
 *
 * @package     Joomla.Platform
 * @subpackage  GitHub
 * @since       11.3
 */
class Github
{
	/**
	 * @var    JRegistry  Options for the GitHub object.
	 * @since  11.3
	 */
	protected $options;

	/**
	 * @var    JGithubHttp  The HTTP client object to use in sending HTTP requests.
	 * @since  11.3
	 */
	protected $client;

	/**
	 * @var    JGithubGists  GitHub API object for gists.
	 * @since  11.3
	 */
	protected $gists;

	/**
	 * @var    JGithubIssues  GitHub API object for issues.
	 * @since  11.3
	 */
	protected $issues;

	/**
	 * @var    JGithubPulls  GitHub API object for pulls.
	 * @since  11.3
	 */
	protected $pulls;

	/**
	 * @var    JGithubRefs  GitHub API object for referencess.
	 * @since  11.3
	 */
	protected $refs;

	/**
	 * @var    JGithubForks  GitHub API object for forks.
	 * @since  11.3
	 */
	protected $forks;

	/**
	 * @var    JGithubCommits  GitHub API object for commits.
	 * @since  12.1
	 */
	protected $commits;

	/**
	 * @var    JGithubMilestones  GitHub API object for milestones.
	 * @since  12.3
	 */
	protected $milestones;

	/**
	 * @var    JGithubStatuses  GitHub API object for statuses.
	 * @since  12.3
	 */
	protected $statuses;

	/**
	 * @var    JGithubAccount  GitHub API object for account references.
	 * @since  12.3
	 */
	protected $account;

	/**
	 * @var    JGithubHooks  GitHub API object for hooks.
	 * @since  12.3
	 */
	protected $hooks;

	/**
	 * Constructor.
	 *
	 * @param   JRegistry    $options  GitHub options object.
	 * @param   JGithubHttp  $client   The HTTP client object.
	 *
	 * @since   11.3
	 */
	public function __construct(Registry $options = null, Http $client = null)
	{
		$this->options = isset($options) ? $options : new Registry;
		$this->client  = isset($client) ? $client : new Http($this->options);

		// Setup the default API url if not already set.
		$this->options->def('api.url', 'https://api.github.com');
	}

	/**
	 * Magic method to lazily create API objects
	 *
	 * @param   string  $name  Name of property to retrieve
	 *
	 * @return  JGithubObject  GitHub API object (gists, issues, pulls, etc).
	 *
	 * @since   11.3
	 */
	public function __get($name)
	{
		if ($name == 'gists')
		{
			if ($this->gists == null)
			{
				$this->gists = new Gists($this->options, $this->client);
			}
			return $this->gists;
		}

		if ($name == 'issues')
		{
			if ($this->issues == null)
			{
				$this->issues = new Issues($this->options, $this->client);
			}
			return $this->issues;
		}

		if ($name == 'pulls')
		{
			if ($this->pulls == null)
			{
				$this->pulls = new Pulls($this->options, $this->client);
			}
			return $this->pulls;
		}

		if ($name == 'refs')
		{
			if ($this->refs == null)
			{
				$this->refs = new Refs($this->options, $this->client);
			}
			return $this->refs;
		}

		if ($name == 'forks')
		{
			if ($this->forks == null)
			{
				$this->forks = new Forks($this->options, $this->client);
			}
			return $this->forks;
		}

		if ($name == 'commits')
		{
			if ($this->commits == null)
			{
				$this->commits = new Commits($this->options, $this->client);
			}
			return $this->commits;
		}

		if ($name == 'milestones')
		{
			if ($this->milestones == null)
			{
				$this->milestones = new Milestones($this->options, $this->client);
			}
			return $this->milestones;
		}

		if ($name == 'statuses')
		{
			if ($this->statuses == null)
			{
				$this->statuses = new Statuses($this->options, $this->client);
			}
			return $this->statuses;
		}

		if ($name == 'account')
		{
			if ($this->account == null)
			{
				$this->account = new Account($this->options, $this->client);
			}
			return $this->account;
		}

		if ($name == 'hooks')
		{
			if ($this->hooks == null)
			{
				$this->hooks = new Hooks($this->options, $this->client);
			}
			return $this->hooks;
		}
	}

	/**
	 * Get an option from the JGitHub instance.
	 *
	 * @param   string  $key  The name of the option to get.
	 *
	 * @return  mixed  The option value.
	 *
	 * @since   11.3
	 */
	public function getOption($key)
	{
		return $this->options->get($key);
	}

	/**
	 * Set an option for the JGitHub instance.
	 *
	 * @param   string  $key    The name of the option to set.
	 * @param   mixed   $value  The option value to set.
	 *
	 * @return  JGitHub  This object for method chaining.
	 *
	 * @since   11.3
	 */
	public function setOption($key, $value)
	{
		$this->options->set($key, $value);

		return $this;
	}
}
