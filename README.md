# Custom Wordpress Theme Development
### Author: Alexander Effanga

## Progress Log
### 10/19/2023
I've always been interested in the Wordpress ecosystem, but haven't made it past the typical drag-and-drop page builder plugins. Certain themes allow a degree of functionality, but even the most flexible of themes have their limitations. The goal here is to
learn the ropes of the Wordpress ecosystem, along with a decent amount of PHP and React, to create a theme that I'll eventually host live.

### 10/23/2023
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
}
```

 ![vague description](assets/images/wp-duotones.png)

 The gradients feature is pretty cool, and it utilizes css to detail the colors the user wishes to use. As expected, it is within the colro settings:

 ```
    "defaultGradients": false,
                "gradients": [
                    {"slug": "u-summer-dog", "name": "Udemy Summer Dog", "gradient": "linear-gradient(#a8ff78, #78ffd6)"}
                ]
 ``` 

 This will cause the screen to look as so: 

![](assets/images/wp-global-gradients.png)

Anywhats, I'm learning more about the theme.json file and just how deep the cutomizations can go on this.

### 11/03/2023
Learned more on how to adjust global styles using theme.json
Not too much to say other than that. 

On another note, I'm now starting to learn about the world of hooks! Basically, hooks are functions that run during events.
It's basically Wordpress' answer to PHP's lack of a proper event-handling mechanism akin to Javascript's. It is by far the most
used API in the WP community. They're used to load both Javascript and css file. Where are hooks stored? The `functions.php` file, of course!
`functions.php` file is responsible for the logic of the theme, while `index.php` is responsible for displaying the content (that is if the `index.html` file isn't already in use). 

#### (Quick note as of 05/04/2024)
`index.php` is usually left blank sense WP FSE is primarily reliant on html-based block and Gutenberg's block grammar. As a result, it looks like this:

```
<?php

```

This is without a doubt, the most complex line of code I have ever written. Whatever is written in `index.php` will be displayed on the website, which is where templates come into play. 

### 11/04/2023
Learned some other functions, such as `add_actions()`, which passes a wordpress hook and the respective function it should call. Two types of files are compatible with `enqueue.php`: CSS and Javascript files. For future reference, it's generally advised to leave php mode when rendering html tags.

### 05/05/2024
Okay,
So it's been a while since I've updated this theme (rather, continued this course), but here we are. With no intention on stopping this time, let's continue.
Right now I'm working on recreating various template parts by further breaking them up into smaller pieces.

![](assets/images/template-parts_one.png)

Right now, it's a bit fugly, at least in the way that it's set up.

#### Block vs Class Settings
When dealing with custom wordperss themes, using css classes is generally seen as faster and grants the decveloper full control of the elements. The only caveat is that it's harder to customize for clients.

Blocks on the otherhand are slower, but allow the clients to customize the theme much easier. The caveat to this is that no other properties are available due to the simplicity of Gutenberg's block designs.

Obviously, there are advantages and disadvanteges on using both, so it's realy up to the developer to decide which route to use.

### 05/06/2024
I spent the majority of the day trying to figure just how the css worked since their wasn't much explanation for the already-established css classes, such as the odd `!mx-auto` and the like. After doing some digging, it turns out that the theme is reliant primarily on tailwind css, but a precompiled, minified version of it. A lot of educaitonal content includes precompiled versions to simplify the process and reduce the need to go through the extra steps of setting up multiple configuration files.

Still not a big fan of the lack of explanation, but we can't have everything spoon fed to us, after all...

Besides that, I did add the css theme into the gutenberg editor by utilizing the WordPress hook, `after_setup_theme()`, which "is used to perform basic setup, registration, and init actions for a theme." ([from wp docs](https://developer.wordpress.org/reference/hooks/after_setup_theme/)). 
So I updated the `functions.php` file with the following:

```
include( get_theme_file_path('/includes/setup.php') );
add_action('after_setup_theme', 'u_setup_theme');
```

and created `setup.php` to include the following as well:

```
function u_setup_theme() {
    add_theme_support('editor-styles');
    add_editor_style([
        'https://fonts.googleapis.com/css2?family=Pacifico&family=Rubik:w
        'assets/bootstrap-icons/bootstrap-icons.css',
        'assets/public/index.css'
    ]);
}
```

The lines of code above allow me to see the two fonts – 'Pacifico' and 'Rubik', bootstrap icons, and the full `index.css` file (the precompiled tailwind file I referred to earlier).

Further along the lesson, I began to notice that the editor styles didn't match the front-end styles. For example:
#### Gutenberg Editor UI

![](assets/images/editor_duality.png)

#### Front-end Display

![](assets/images/editor_frontend.png)

The reason being is due to the markup that wordpress generates for the front-end is different from the editor. The best way to fix that would be to manually input css specific styling for the section you want to match for the front-end, which can be a pain in the ass if one wants the all of the content made with the editor to match the front-end. So with that, I'll leave it be; tabs exist for a reason.


### 05/07/2024

I completed the header template by "transferring" the block code (manually copying from the gutenberg editor) into `header.html`.

So, the whole process involves hardcoding the html for the block parts, copying and pasting them onto the block editor (using the custom html block), recreate the block parts using the native gutneberg blocks (with the imported tailwind css), and finally replacing the original hard-coded html block parts with the copied block grammar/code from the visual editor.

I'm assuming the step involved were done for purely educational purposes. Hopefully we can go over custom block development in order to avoid going through such lengths.

#### <span style ="color:#80b3ff"> The Query Loop Block </span>
This project's first piece of dynamic content. The Query Loop Block grabs posts from the wp database and rendering them on a page with pagination. This block is the modern,updated version of what was once known as "The Loop".

When looking at the block, it's easy to assume that the query loop is doing all the work. In reality, the query loop grabs the data/content, but doesn't present it. It's child block, "Post Content" presents the data.

#### <span style ="color:#80b3ff"> What is a Query? </span>
A Query is a request for data from a database. Behind the scenes, WordPress will always perform a query on every page, posting data relating to the current url that it is on automatically.

#### <span style ="color:#80b3ff">Small issue on this part of the lesson.</span>
As I went furhter along the lesson revolving around the query loop, the instructor used a block that shows the amount of comments a post has titled "Comments Count", which is a experimental feature that's only accessible through the Gutenberg plugin. That we have to download. For a course going over how to build custom themes and plugins from scratch.

A part of me wants to completely bypass this and find alternative to using this plugin (since I'm trying to use as few plugins as possible), but I can't let my ego/temperment get the better of me...ugh...

I went ahead and downloaded the plugin, and the visual editor looks a lot better! The block UI is a lot less clunky and, of course, the unseen blocks I was lamenting about finally appeared. Granted, said blocks are yet to be seen in the official release, and after doing some digging, "Comments Count" has been around since at least 2021.

All in all, I didn't get too much done today due to the massive amount of backtracking and off-tangent research regarding these 'mysterious' blocks.

### 05/08/2024

I ended up creating a sidebar template for the main blog, which was mostly done with the visual editor. Sure, I copied some code from the index.html template, but it was small in comparison.

```
      <div class="mb-8">
        <h6 class="text-xl font-medium mb-5">Trending Posts</h6>
        <div class="flex mb-4 items-center">
          <!-- Post Image -->
          <a class="shrink-0" href="#">
            <img class="rounded-lg w-16" src="/public/trending-01.jpg">
          </a>
          <div class="text-sm ml-4">
            <!-- Post Title -->
            <a class="block font-medium" href="blog-single.html">
              Retro Cameras are Trending. Why so Popular?
            </a>
            <!-- Post Author -->
            <span class="text-gray-500">
              by <a href="#">Andy Williams</a>
            </span>
          </div>
        </div>
        <div class="flex mb-4 items-center">
          <a class="shrink-0" href="#">
            <img class="rounded-lg w-16" src="/public/trending-02.jpg">
          </a>
          <div class="text-sm ml-4">
            <a class="block font-medium" href="blog-single.html">
              Retro Cameras are Trending. Why so Popular?
            </a>
            <span class="text-gray-500">
              by <a href="#">Andy Williams</a>
            </span>
          </div>
        </div>
        <div class="flex mb-4 items-center">
          <a class="shrink-0" href="#">
            <img class="rounded-lg w-16" src="/public/trending-03.jpg">
          </a>
          <div class="text-sm ml-4">
            <a class="block font-medium" href="blog-single.html">
              Retro Cameras are Trending. Why so Popular?
            </a>
            <span class="text-gray-500">
              by <a href="#">Andy Williams</a>
            </span>
          </div>
        </div>
      </div>
```

Now that the index page is completed – that is creating a perfect copy of the hard-written html code using a combination of custom html (with block-grammar), the task for today was doing the same for the footer template part. I did exactly the same thing for the footer as I did for the header and body part, but I failed to reset the customization settings done onto the page, so I didn't notice any change the original footer as a result. I ended up spendign a few hours of my evening bashing my head against the wall trying to figure out what went wrong. So yeah; always remember to reset customizations on the visual editor once the template part file has been updated or altered in any way.

Now onto the templates...
I blitzed through creating `404.html`, `category.html`, `search.html`, `single.html`, and `page.html` 

#### <span style="color:#80b3ff"> Quick Note on `single.html` </span>
Like the other templates, `single.html` is built using `index.html` as its base. What makes `single.html` stand out is that we're taking the post template columns directly outside of the query loop (using the site editor). Because of the [template hiearchy ](https://developer.wordpress.org/themes/basics/template-hierarchy/), Wordpress processes the page (or post) request by looking at the slug. As long as the post material is on the page, wordpress will return the post relating to the page's slug (which should only be one).
Children loop blocks can render the post data, so having the parent loop through the every post in the database is unnecessary.

### 05/09/2024

I finished the template section with a `full-width-page.html`, which I created using the page template as the blueprint and registering it on `theme.json`.

#### <span style="color:#80b3ff">Onto to the big leagues: React and Block Development.</span>

As it turns out, React is more than a library, it provides a set of tools that help with product optimization once said product is good to go.

`import React from 'react'` is very similar to how the `include()` function works in php. Javascript works by breaking up code into differeent pieces that serve a purpose called **modules**.

So much to learn, so little time, it seems. The course is using outdated React code, but I'll still follow along so I won't get too lost in the sauce. This time around, I've learned about the function of "memory leaks", which is a pretty massive problem in programming. If a variable isn't needed, it's best to clear it, which is why returning elements from a function instead of a variable is seen as important. Take the following, for example:
```
const loginForm = React.createElement('form');

if(someCondition) {
  ReactDom.render(loginForm, document.querySelector('#root'));
}
```
The code above has a value stored in a variable, which is common practice...if you're a fuckin' noob.
But in all seriousness, keeping a value stored in a variable can eventually become expensive and inefficient since the variable takes up space. Compare that to this:
```
function loginForm() {
  return React.createElement('form')'
}

if(someCondition) {
  ReactDom.render(loginForm(), document.querySelector('#root'));
}
```
This will only return a variable if it the function is called, ultimately avoiding a leak.

Here's a better example:
Starting with the variable version.
```
import React from 'react'
import ReactDom from 'react-dom/client';

const div = React.createElement( 'div', null, [
  React.createElement('h1', null, 'Hi'),
  React.createElement('p', null, 'Hello'),
  React.createElement('p', null, 'hey')
]);
const rootElement = document.querySelector('#root');
const root = ReactDom.createRoot(rootElement);

root.render(div)
```
Here is the function version:
```
import React from 'react'
import ReactDom from 'react-dom/client';

function Page() {
  return React.createElement( 'div', null, [
    React.createElement('h1', null, 'Hi'),
    React.createElement('p', null, 'Hello'),
    React.createElement('p', null, 'hey')
  ]);
}

const rootElement = document.querySelector('#root');
const root = ReactDom.createRoot(rootElement);

root.render(Page())
```

Side note: webpack will convert JSX into the `React.createElement()` function. JSX is not HTML.

##### jsx version

```
import React from 'react'
import ReactDom from 'react-dom/client

function Page () {
  return(
    <div>
      <h1> Hello </h1>
      <p> Hey </p>
      <p> Hi </p>
    </div>
  );
}
  const rootElement = document.querySelector('#root');
  const root = ReactDom.createRoot(rootElement);

  root.render(Page())

```

### 05/11/2024

For more information on importing and exporting components, [medium](https://betterprogramming.pub/understanding-the-difference-between-named-and-default-exports-in-react-2d253ca9fc22) provides a great article on the subject.

#### <span style = "color: #80b3ff">Other React Notes </span>
It's worth mentioning that this portion of the course is a very, very brief introduction to React. I'll work on a different project that'll utilize React at a much deeper level, but for now:

- Before being loaded onto the internet, webPack processes the code as a package, which bundles and optimizes our code.

- React needs a root/parent element to wrap elements in. Divs are the default value, but it is becoming increasingly commonplace to use fragment `<>` `</>` tags for wrapping. Although empty, the DOM converts them into `<div>` tags with class name `root`.
Other 

- exports without a default tag are named exports. They usually use the name of the function or class name as the identifier. When you export them, simply apply the `export` tag beforehand, so it'll look like `export function myComponent() {//code}`. So when importing into another component, it would look like:
`import {myComponent} from '/path/to/myComponent'`.
  - A cool thing with named exports is that you can use what's called **opt-in alias**. This is when a component is given a different name in order to prevent collisions in a file.
  ```
  import {myCompOne as myComponent} from 'path/to/file'
  ```
  - Multiple components within the same file can be exported:
  ```
  export const myCompOne = () => {};

  export const myCompTwo = () => {};

  export const myCompThree = () => {};
  ```
    -to import multiple components onto a different file, just seperate them by commas within the curly brackets.
  `import { myCompOne, myCompTwo, myCompThree } from './path/to/file'`

- exports with a default tag are default exports.
  - When exporting, there's no need to wrap the components in curly brackets

- jsx uses the keyword `className` in place of `class`. This can be used for altering the style of a document by connecting to css
  - `<h1 className = 'orange'> hi </h1>`

- you have to import the css file into the reactjs file. For example 
  - `import ./style.css`

-HTML was never made to be scalable, which is why dynamic progamming is important It's less taxing on memory and efficiency. HTML cannot split itself into various files like css and javascript can, so this is where components come into play. This is where components come into play.
  -The proper definition of a component is a reusable block of code that encapsulates the logic, structure, and presentation of a ui element. It essentially creates brand new tags for html to use for a webpage when a function is called on.

- props are react's equivalent to html attributes, just like `className` is React's equivalent to a css `class`.
```
function Header(props) {
  const clock = Date().toLocaleString();
  return (
    <h1 className="orange">
     Hello {props.name}! {clock}
    </h1>
  );
}
```

in some cases, there may be situations where one would want to pass on dynamic data
```
function Header(props) {
  const clock = Date.toLocaleString();
  return (
    <h1 className = "orange"> 
      Hello {props.name}. The Current time is {clock}
    <h1/>
  )
}

function Page() {
  const name = "John";
  return (
    <>
      <Header name={name} />
      <p>This is a paragraph</p>
      <p>This is another paragraph</p>
    </>
  );
}
```

- Components are regular JavaScript functions, so you can keep multiple components in the same file. This is convenient when components are relatively small or tightly related to each other.

- Never define a component inside another component!

- As stated in the [official React Docs](https://react.dev/learn/your-first-component), all components must start with a capital letter otherwise it won't work.

- A namespace is a feature for organizing data into seperate locations.

- `React.useState()` is a react hook that registers a piece of data with a component. Syntactically, it is an array that uses two inputs

- A state is data that is registered within a component that is (usually) prone to change.

Hell, I have so much more to learn...`

### 05/12/2024

#### <span style="color:#80b3ff">The Meat of The Course: Block Development Fundamentals</span>

- Wordpress exposes its api to both plugins and themes, but for the sake of SOC, it's best to keep plugins (or in this case, blocks) and themes loosely coupled. This can save a lot of headache later down the road.

- Registering a plugin is similar to registering a theme.

#### 05/25/2024
I spent the past two weeks working primarily on this theme's required plugins. So far, I have built the fancy header, which is a stupid-simple block that just animates a highlight under a title, and am currently working on a search-form block. That one is a little more intensive as I'm finally implementing some actual php, and learning about various wordpress apis. Anyways, I came in to update this log since I had to copy the block grammaar from the updated search-form template (which is utlizing the aforementioned 'search-form' block).