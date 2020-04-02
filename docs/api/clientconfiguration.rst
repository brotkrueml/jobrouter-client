.. include:: ../Includes.txt

.. _api-clientconfiguration:

==================================
Configuration\\ClientConfiguration
==================================

.. php:class:: final Brotkrueml\\JobRouterClient\\Configuration\\ClientConfiguration

   Immutable value object that represents the configuration for a RestClient.

   .. php:const:: const MAXIMUM_ALLOWED_TOKEN_LIFETIME_IN_SECONDS = 3600

      The maximum lifetime of an authentication token in seconds as defined by
      JobRouter.

   .. php:const:: const MINIMUM_ALLOWED_TOKEN_LIFETIME_IN_SECONDS = 0

      The minimum lifetime of an authentication token in seconds as defined by
      JobRouter.

   .. php:const:: const DEFAULT_TOKEN_LIFETIME_IN_SECONDS = 600

      The default lifetime of an authentication token in seconds as defined by
      JobRouter.

   .. php:method:: __construct($baseUrl, $username, $password)

      The constructor receives the base URL of the JobRouter system and the
      credentials.

      :param string $baseUrl: The base URL of the JobRouter system.
      :param string $username: The username, must not be empty.
      :param string $password: The password, must not be empty.

   .. php:method:: getUserAgentAddition()

      Retrieve the user agent addition.

      :returns string: The user agent addition.

   .. php:method:: getBaseUrl()

      Retrieve the base URL.

      :returns string: The base URL.

   .. php:method:: getLifetime()

      Retrieve the lifetime of the authentication token.

      :returns int: The lifetime.

   .. php:method:: getPassword()

      Retrieve the password.

      :returns string: The password.

   .. php:method:: getUsername()

      Retrieve the username.

      :returns string: The username.

   .. php:method:: withUserAgentAddition($userAgentAddition)

      Set a user agent addition. By default, the user agent is set to the
      JobRouter Client. You can add e.g. your script to the user agent.

      :param string $userAgentAddition: The user agent addition.
      :returns self: A new instance of the configuration.

   .. php:method:: withLifetime($lifetime)

      :param int $lifetime: The lifetime in seconds. It must be between 0 and 3600.
      :returns self: A new instance of the configuration.


Usage Example
-------------

::

   <?php
   use Brotkrueml\JobRouterClient\Configuration\ClientConfiguration;

   require_once 'vendor/autoload.php';

   $configuration = new ClientConfiguration(
      'https://example.org/jobrouter/',
      'the_user',
      'the_password'
   );

   // As ClientConfiguration is an immutable value object, a
   // new instance of the configuration object is returned
   $configuration = $configuration->withLifetime(
      ClientConfiguration::MAXIMUM_ALLOWED_TOKEN_LIFETIME_IN_SECONDS
   );
   $configuration = $configuration->withUserAgentAddition(
      'LooneyTunesArchiveImporter/1.2'
   );