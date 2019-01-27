# lcss
Light CSS pre processor

Only one feature : Selector inheritance.
It consists to point hierarchicaly to your selectors, then children blocks don't have to repeat parents definition. And imported css (with @import) should be realy more reusable.
For emacs users, you can think about minors/majors modes. It's the same.
You define one or some "lcss" witch is a minor context, specific to your web site, and the imported css children should be major, easy to use in other contexts, because of selector inheritance.
They should be as short as possible, and strongly reusable, and they can take advange of already existing css variables (see https://developer.mozilla.org/en-US/docs/Web/CSS/Using_CSS_variables)

Just transform this :
```
@(#parent1) {
  @(.sub1.myClass > span, .sub2.active) {
    body { color: #888; }
    @media print {
      body { color: #333; }
    }
  }
  @(.sub3) {
    code { color: red; }
  }
  code { color: blue; }
}

@(#parent) {
  .sous-style {
    display: none;
  }
}
```

To this :

```
#parent1 .sub1.myClass > span body, #parent1  .sub2.active body {
 color: #888; 
}

@media print {
#parent1 .sub1.myClass > span body, #parent1  .sub2.active body {
 color: #333; 
}


}

#parent1 .sub3 code {
 color: red; 
}

#parent1 code {
 color: blue; 
}

#parent .sous-style {

    display: none;
  
}

```


That's all folks!
Do you realy need more?


TODO :
======

* parse imported files (@import) adding parent selectors
* Remove or keep comments ?
* Two modes. With indentation to help debugging, and integrated minification


