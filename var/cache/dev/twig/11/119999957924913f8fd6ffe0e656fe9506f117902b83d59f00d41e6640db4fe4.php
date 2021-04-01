<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* home/index.html.twig */
class __TwigTemplate_8b1aad119c78ae77799be307b33e3db62a6df0635ffe39f48a4712ec4cd4bc8a extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "home/index.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "home/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "home/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo "Hello HomeController!
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 6
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 7
        echo "\t<style>

\t\t/* Style the tab */
\t\t.tab {
\t\t\toverflow: hidden;
\t\t\tborder: 1px solid #ccc;
\t\t\tbackground-color: #f1f1f1;
\t\t}

\t\t/* Style the buttons inside the tab */
\t\t.tab button {
\t\t\tbackground-color: inherit;
\t\t\tfloat: left;
\t\t\tborder: none;
\t\t\toutline: none;
\t\t\tcursor: pointer;
\t\t\tpadding: 14px 16px;
\t\t\ttransition: 0.3s;
\t\t\tfont-size: 17px;
\t\t}

\t\t/* Change background color of buttons on hover */
\t\t.tab button:hover {
\t\t\tbackground-color: #ddd;
\t\t}

\t\t/* Create an active/current tablink class */
\t\t.tab button.active {
\t\t\tbackground-color: #ccc;
\t\t}

\t\t/* Style the tab content */
\t\t.tabcontent {
\t\t\tdisplay: none;
\t\t\tpadding: 6px 12px;
\t\t\tborder: 1px solid #ccc;
\t\t\tborder-top: none;
\t\t}
\t</style>

\t<div class=\"example-wrapper\">
\t\t<h1>Hello ! ✅</h1>

\t\tWhat mood are you in today ?


\t\t<div class=\"tab\">
\t\t\t<button class=\"tablinks\" onclick=\"openCity(event, 'Mood')\">Mood</button>
\t\t\t<button class=\"tablinks\" onclick=\"openCity(event, 'Artist')\">Artist</button>
\t\t\t<button class=\"tablinks\" onclick=\"openCity(event, 'Year')\">Year</button>
\t\t</div>
\t\t\t<form action=\"/player/\" method=\"get\">

\t\t<div id=\"Mood\" class=\"tabcontent\">
\t\t\t\t<ul>
\t\t\t\t\t";
        // line 62
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["moods"]) || array_key_exists("moods", $context) ? $context["moods"] : (function () { throw new RuntimeError('Variable "moods" does not exist.', 62, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["mood"]) {
            // line 63
            echo "\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"mood[]\" value=\"";
            // line 64
            echo twig_escape_filter($this->env, $context["mood"], "html", null, true);
            echo "\" id=\"";
            echo twig_escape_filter($this->env, $context["mood"], "html", null, true);
            echo "\"><label for=\"";
            echo twig_escape_filter($this->env, $context["mood"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["mood"], "html", null, true);
            echo "</label>
\t\t\t\t\t\t</li>

\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['mood'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 68
        echo "\t\t\t\t</ul>
\t\t\t\t<input type=\"submit\" value=\"Submit\">

\t\t</div>

\t\t<div id=\"Artist\" class=\"tabcontent\">
\t\t\t\t<ul>
\t\t\t\t\t";
        // line 75
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["artists"]) || array_key_exists("artists", $context) ? $context["artists"] : (function () { throw new RuntimeError('Variable "artists" does not exist.', 75, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["artist"]) {
            // line 76
            echo "\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"artist[]\" value=\"";
            // line 77
            echo twig_escape_filter($this->env, $context["artist"], "html", null, true);
            echo "\" id=\"";
            echo twig_escape_filter($this->env, $context["artist"], "html", null, true);
            echo "\"><label for=\"";
            echo twig_escape_filter($this->env, $context["artist"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["artist"], "html", null, true);
            echo "</label>
\t\t\t\t\t\t</li>
\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['artist'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 80
        echo "\t\t\t\t</ul>
\t\t\t\t<input type=\"submit\" value=\"Submit\">

\t\t</div>

\t\t<div id=\"Year\" class=\"tabcontent\">
\t\t\t\t<ul>
\t\t\t\t\t";
        // line 87
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["years"]) || array_key_exists("years", $context) ? $context["years"] : (function () { throw new RuntimeError('Variable "years" does not exist.', 87, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["year"]) {
            // line 88
            echo "\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"year[]\" value=\"";
            // line 89
            echo twig_escape_filter($this->env, $context["year"], "html", null, true);
            echo "\" id=\"";
            echo twig_escape_filter($this->env, $context["year"], "html", null, true);
            echo "\"><label for=\"";
            echo twig_escape_filter($this->env, $context["year"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["year"], "html", null, true);
            echo "</label>
\t\t\t\t\t\t</li>
\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['year'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 92
        echo "\t\t\t\t</ul>
\t\t\t\t<input type=\"submit\" value=\"Submit\">
\t\t</div>
\t\t\t</form>

<script>
\tfunction openCity(evt, cityName) {
\t\tvar i,
\t\ttabcontent,
\t\ttablinks;
\t\ttabcontent = document.getElementsByClassName(\"tabcontent\");

\t\tfor (i = 0; i < tabcontent.length; i++) {
\t\t\ttabcontent[i].style.display = \"none\";
\t\t}

\t\ttablinks = document.getElementsByClassName(\"tablinks\");
\t\tfor (i = 0; i < tablinks.length; i++) {
\t\t\ttablinks[i].className = tablinks[i].className.replace(\" active\", \"\");
\t\t}

\t\tdocument.getElementById(cityName).style.display = \"block\";
\t\tevt.currentTarget.className += \" active\";
\t}
</script>


\t</div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "home/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  231 => 92,  216 => 89,  213 => 88,  209 => 87,  200 => 80,  185 => 77,  182 => 76,  178 => 75,  169 => 68,  153 => 64,  150 => 63,  146 => 62,  89 => 7,  79 => 6,  59 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Hello HomeController!
{% endblock %}

{% block body %}
\t<style>

\t\t/* Style the tab */
\t\t.tab {
\t\t\toverflow: hidden;
\t\t\tborder: 1px solid #ccc;
\t\t\tbackground-color: #f1f1f1;
\t\t}

\t\t/* Style the buttons inside the tab */
\t\t.tab button {
\t\t\tbackground-color: inherit;
\t\t\tfloat: left;
\t\t\tborder: none;
\t\t\toutline: none;
\t\t\tcursor: pointer;
\t\t\tpadding: 14px 16px;
\t\t\ttransition: 0.3s;
\t\t\tfont-size: 17px;
\t\t}

\t\t/* Change background color of buttons on hover */
\t\t.tab button:hover {
\t\t\tbackground-color: #ddd;
\t\t}

\t\t/* Create an active/current tablink class */
\t\t.tab button.active {
\t\t\tbackground-color: #ccc;
\t\t}

\t\t/* Style the tab content */
\t\t.tabcontent {
\t\t\tdisplay: none;
\t\t\tpadding: 6px 12px;
\t\t\tborder: 1px solid #ccc;
\t\t\tborder-top: none;
\t\t}
\t</style>

\t<div class=\"example-wrapper\">
\t\t<h1>Hello ! ✅</h1>

\t\tWhat mood are you in today ?


\t\t<div class=\"tab\">
\t\t\t<button class=\"tablinks\" onclick=\"openCity(event, 'Mood')\">Mood</button>
\t\t\t<button class=\"tablinks\" onclick=\"openCity(event, 'Artist')\">Artist</button>
\t\t\t<button class=\"tablinks\" onclick=\"openCity(event, 'Year')\">Year</button>
\t\t</div>
\t\t\t<form action=\"/player/\" method=\"get\">

\t\t<div id=\"Mood\" class=\"tabcontent\">
\t\t\t\t<ul>
\t\t\t\t\t{% for mood in moods %}
\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"mood[]\" value=\"{{mood}}\" id=\"{{mood}}\"><label for=\"{{mood}}\">{{mood}}</label>
\t\t\t\t\t\t</li>

\t\t\t\t\t{% endfor %}
\t\t\t\t</ul>
\t\t\t\t<input type=\"submit\" value=\"Submit\">

\t\t</div>

\t\t<div id=\"Artist\" class=\"tabcontent\">
\t\t\t\t<ul>
\t\t\t\t\t{% for artist in artists %}
\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"artist[]\" value=\"{{artist}}\" id=\"{{artist}}\"><label for=\"{{artist}}\">{{artist}}</label>
\t\t\t\t\t\t</li>
\t\t\t\t\t{% endfor %}
\t\t\t\t</ul>
\t\t\t\t<input type=\"submit\" value=\"Submit\">

\t\t</div>

\t\t<div id=\"Year\" class=\"tabcontent\">
\t\t\t\t<ul>
\t\t\t\t\t{% for year in years %}
\t\t\t\t\t\t<li>
\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"year[]\" value=\"{{year}}\" id=\"{{year}}\"><label for=\"{{year}}\">{{year}}</label>
\t\t\t\t\t\t</li>
\t\t\t\t\t{% endfor %}
\t\t\t\t</ul>
\t\t\t\t<input type=\"submit\" value=\"Submit\">
\t\t</div>
\t\t\t</form>

<script>
\tfunction openCity(evt, cityName) {
\t\tvar i,
\t\ttabcontent,
\t\ttablinks;
\t\ttabcontent = document.getElementsByClassName(\"tabcontent\");

\t\tfor (i = 0; i < tabcontent.length; i++) {
\t\t\ttabcontent[i].style.display = \"none\";
\t\t}

\t\ttablinks = document.getElementsByClassName(\"tablinks\");
\t\tfor (i = 0; i < tablinks.length; i++) {
\t\t\ttablinks[i].className = tablinks[i].className.replace(\" active\", \"\");
\t\t}

\t\tdocument.getElementById(cityName).style.display = \"block\";
\t\tevt.currentTarget.className += \" active\";
\t}
</script>


\t</div>
{% endblock %}
", "home/index.html.twig", "/var/www/html/templates/home/index.html.twig");
    }
}
