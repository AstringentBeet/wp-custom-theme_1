# Custom Wordpress Theme Development
### Author: Alexander Effanga

### Progress Log
#### 10/19/2023
I've always been interested in the Wordpress ecosystem, but haven't made it past the typical drag-and-drop page builder plugins. Certain themes allow a degree of functionality, but even the most flexible of themes have their limitations. The goal here is to
learn the ropes of the Wordpress ecosystem, along with a decent amount of PHP and React, to create a theme that I'll eventually host live.

#### 10/23/2023
I don't see myself using Duotones on Wordpress, but I feel like it's worth mentioning on here. Duotones for Wordpress is an experimental feture that allows the user to place a color-based filter on top of an image. The name stems from the fact that a user is required to enter two different colors, a darker color and lighter color, in order to create a dynamic color effect.

```
"settings": {
        "color": {
            "defaultPalette": false,
                "background": true,
                "text": true,
                "link": true,
                "custom": false,
                "duotone": [
                    {"slug": "u-pink-sunset", "colors": ["#11245e", "#dc4379"], "name": "pink-sunset"}
                ]
        }
```
 ![vague description](/wp-content/themes/udemy/assets/images/wp-duotones.png)

 The gradients feature is pretty cool, and it utilizes css to detail the colors the user wishes to use. As expected, it is within the colro settings:
 ```
    "defaultGradients": false,
                "gradients": [
                    {"slug": "u-summer-dog", "name": "Udemy Summer Dog", "gradient": "linear-gradient(#a8ff78, #78ffd6)"}
                ]
 ``` 
 This will cause the screen to look as so: 
![](/wp-content/themes/udemy/assets/images/wp-global-gradients.png)

Anywhats, I'm learning more about the theme.json file and just how deep the cutomizations can go on this.

#### 11/03/2023
Learned more on how to adjust global styles using theme.json
Not too much to say other than that. 

On another note, I'm now starting to learn about the world of hooks! Basically, hooks are functions that run during events.
It's basically Wordpress' answer to PHP's lack of a proper event-handling mechanism akin to Javascript's. It is by far the most
used API in the WP community. They're used to load both Javascript and css file. Where are hooks stored? The `functions.php` file, of course!
`functions.php` file is responsible for the logic of the theme, while `index.php` is responsible for displaying the content (that is if the `index.html` file isn't already in use).

#### 11/04/2023
Learned some other functions, such as `add_actions()`, which passes a wordpress hook and the respective function it should call. Two types of files are compatible with `enqueue.php`: CSS and Javascript files. For future reference, it's generally advised to leave php mode when rendering html tags.