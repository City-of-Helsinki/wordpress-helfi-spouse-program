# wordpress-helfi-spouse-program

WP Theme for Spouse Program



Production update:

1. Run the production build in the main branch with the command `npm run gulp-prod`

2. After the build files are generated, change the version number located in `style.css`. Keep in mind that generating a new build typically changes the version number back to `Version: 1.0`. Commit this change to GitHub. Keep in mind that if no CSS/JS changes have been made, creating the build might be unnecessary. However, the version change in the `style.css` must be made.

⚠️ The deploy process does not run the build automatically, so these two steps must be done manually!

3. Create a new release in GitHub
    - Click **Releases → Draft a new release**
    - Create a new tag that matches the version number that you’ve changed in `styles.css`, so **2.5.1** for example.
    - Add a release title, generally it can be just the version number
    - Click on **Generate release notes**. Notes will be populated in the description box, typically pull requests. Double check that they are correct.
    - Check the box: **Set as the latest release**
    - Publish the release

6. After publishing the release, wait until the deploy system kicks in and starts the update. A trigger is triggered when a new release tag is created, and if it matches the version number in the style file, the deploy process begins. Note that the deploy bot can in some cases take a while to begin the deployment process.
