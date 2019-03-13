CombynaBundle
=============

The Symfony bundle for [Combyna](https://github.com/combyna/combyna).

## Features:

- Provides a Symfony kernel cache warmer for ensuring the Combyna service container is built
- Defines the `Bootstrap` services for each Originator (`client` and `server`)
- Provides a console command for warming the client cache, as needed for a front-end build by Webpack.
