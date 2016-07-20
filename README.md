# Pantheon Quicksilver CircleCI Integration #

This script shows how to integrate CircleCI with your Pantheon project using Quicksilver. We also show you how to manage API keys outside of your site repository.

## Instructions ##

1. Create a file pantheon.yml for Quicksilver configuration and place it at the root of the site's code directory with the following contents:
  ```yaml
    api_version: 1

    workflows:
      deploy:
        after:
            - type: webphp
              description: Initiate a new build at Circle CI
              script: private/scripts/circleci_notification.php
  ```
2. Create a file called `secrets.json` and store it in the [private files](https://pantheon.io/docs/articles/sites/private-files/) directory of test environment.

  ```shell
    $> echo '{ "username":"YOUR USER NAME", "project":"pcms-automated-testing", "token":"YOUR API KEY" }' > secrets.json
    $> `terminus site connection-info --env=dev --site=your-site --field=sftp_command`
        Connected to appserver.dev.d1ef01f8-364c-4b91-a8e4-f2a46f14237e.drush.in.
    sftp> cd files  
    sftp> mkdir private
    sftp> cd private
    sftp> put secrets.json
  ```

3. Add the example `circleci_notification.php` script to the `private/scripts`  directory in the root of your site's codebase, that is under version control. Note this is a different `private` directory than where the secrets.json is stored and you can create by yourself if you don't have it.
4. Test a deploy out!
