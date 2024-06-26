# Lilut

Lilut is a ridiculously simple PHP-based web tool for applying ready-made Hald CLUT presets to JPEG files.

<img src="lilut.png" alt="Lilut"/>

## Dependencies

- PHP
- php-imagick
- Git (optional)

## Installation and usage

1. Install the required packages on a local machine or a remote web server.
2. Clone the project's repository using the `git clone https://github.com/dmpop/lilut.git` command. Alternatively, download the latest source code using the appropriate button on the project's pages.
3. Put Hald CLUT files into the _lilut/luts_ directory.
4. Open the _index.php_ file and change the default footer text (this step is optional).

To run Lilut locally, switch in the terminal to the _lilut_ directory and  run the `php -S 0.0.0.0:8000` command and point the browser to the _127.0.0.1:8000_ address.

To install Lilut on a web server with PHP, copy the _lilut_ directory to the document root of your server.

The [Linux Photography](https://gumroad.com/l/linux-photography) book provides additional information  on creating Hald CLUT presets for use with Lilut. Get your copy at [Google Play Store](https://play.google.com/store/books/details/Dmitri_Popov_Linux_Photography?id=cO70CwAAQBAJ) or [Gumroad](https://gumroad.com/l/linux-photography).

<img src="https://cameracode.coffee/uploads/linux-photography.png" title="Linux Photography" width="300"/>

## Problems?

Please report bugs and issues in the [Issues](https://github.com/dmpop/lilut/issues) section.

## Contribute

If you've found a bug or have a suggestion for improvement, open an issue in the [Issues](https://github.com/dmpop/lilut/issues) section.

To add a new feature or fix issues yourself, follow the following steps.

1. Fork the project's repository.
2. Create a feature branch using the `git checkout -b new-feature` command.
3. Add your new feature or fix bugs and run the `git commit -am 'Add a new feature'` command to commit changes.
4. Push changes using the `git push origin new-feature` command.
5. Submit a pull request.

## Author

Dmitri Popov [dmpop@cameracode.coffee](mailto:dmpop@cameracode.coffee)

## License

The [GNU General Public License version 3](http://www.gnu.org/licenses/gpl-3.0.en.html)
 
