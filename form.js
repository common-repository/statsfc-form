/* global statsfc_lang */

var $j = jQuery;

function StatsFC_Form (key) {
  this.referer = '';
  this.key = key;
  this.competition = 'EPL';
  this.team = '';
  this.year = '';
  this.date = '';
  this.limit = 0;
  this.highlight = '';
  this.showBadges = false;
  this.showScore = false;
  this.omitErrors = false;
  this.useDefaultCss = false;
  this.lang = 'en';

  this.translate = function (key) {
    if (
      typeof statsfc_lang === 'undefined' ||
      typeof statsfc_lang[key] === 'undefined' ||
      statsfc_lang[key].length === 0
    ) {
      return key;
    }

    return statsfc_lang[key];
  };

  this.display = function (placeholder) {
    this.loadLang('statsfc-lang', this.lang);

    var $placeholder;

    switch (typeof placeholder) {
      case 'string':
        $placeholder = $j('#' + placeholder);
        break;
      case 'object':
        $placeholder = placeholder;
        break;
      default:
        return;
    }

    if ($placeholder.length === 0) {
      return;
    }

    if (this.useDefaultCss === true || this.useDefaultCss === 'true') {
      this.loadCss('statsfc-form-css');
    }

    if (typeof this.referer !== 'string' || this.referer.length === 0) {
      this.referer = window.location.hostname;
    }

    var $container = $j('<div>').addClass('sfc_form');

    // Store globals variables here so we can use it later.
    var highlight = this.highlight;
    var showBadges = (this.showBadges === true || this.showBadges === 'true');
    var showScore = (this.showScore === true || this.showScore === 'true');
    var omitErrors = (this.omitErrors === true || this.omitErrors === 'true');
    var translate = this.translate;

    $j.getJSON(
      'https://widgets.statsfc.com/api/form.json?callback=?',
      {
        key: this.key,
        domain: this.referer,
        competition: this.competition,
        team: this.team,
        year: this.year,
        date: this.date,
        limit: this.limit,
        badges: this.showBadges,
        showScore: this.showScore,
      },
      function (data) {
        if (data.error) {
          if (omitErrors) {
            return;
          }

          var $error = $j('<p>').css('text-align', 'center');

          if (data.customer && data.customer.attribution) {
            $error.append(
              $j('<a>').attr({
                href: 'https://statsfc.com',
                title: 'Football widgets and API',
                target: '_blank',
              }).text('Stats FC'),
              ' – ',
            );
          }

          $error.append(translate(data.error));

          $container.append($error);

          return;
        }

        var $table = $j('<table>');
        var $thead = $j('<thead>');
        var $tbody = $j('<tbody>');

        var $team = $j('<th>').text(translate('Team'));
        if (showBadges) {
          $team.addClass('sfc_team');
        }

        $thead.append(
          $j('<tr>').append(
            $j('<th>'),
            $team,
            $j('<th>').text(translate('Form')),
          ),
        );

        if (data.form.length > 0) {
          $j.each(data.form, function (key, val) {
            var $row = $j('<tr>');

            if (highlight === val.team) {
              $row.addClass('sfc_highlight');
            }

            var $team = $j('<td>').addClass('sfc_team sfc_badge_' + val.path).text(val.team);
            var $formData = $j('<td>').addClass('sfc_form');

            if (showBadges) {
              $team.css('background-image', 'url(https://cdn.statsfc.com/kit/' + val.shirt + ')');
            }

            $j.each(val.form, function (formKey, formVal) {
              var $result = $j('<span>').addClass('sfc_' + formVal.result).text(translate(formVal.result)),
                $data;

              if (showScore) {
                $data = $j('<abbr>').attr('title', formVal.score).append($result);
              } else {
                $data = $result;
              }

              $formData.append($data);
            });

            $row.append(
              $j('<td>').addClass('sfc_numeric').text(val.pos),
              $team,
              $formData,
            );

            $tbody.append($row);
          });

          $table.append($thead, $tbody);
        }

        $container.append($table);

        if (data.customer.attribution) {
          $container.append(
            $j('<div>').attr('class', 'sfc_footer').append(
              $j('<p>').append(
                $j('<small>').append('Powered by ').append(
                  $j('<a>').attr({
                    href: 'https://statsfc.com',
                    title: 'StatsFC – Football widgets',
                    target: '_blank',
                  }).text('StatsFC.com'),
                ),
              ),
            ),
          );
        }
      },
    );

    $placeholder.append($container);
  };

  this.loadCss = function (id) {
    if (document.getElementById(id)) {
      return;
    }

    var css, fcss = (document.getElementsByTagName('link')[0] || document.getElementsByTagName('script')[0]);

    css = document.createElement('link');
    css.id = id;
    css.rel = 'stylesheet';
    css.href = 'https://cdn.statsfc.com/css/form.css';

    fcss.parentNode.insertBefore(css, fcss);
  };

  this.loadLang = function (id, l) {
    if (document.getElementById(id)) {
      return;
    }

    var lang, flang = document.getElementsByTagName('script')[0];

    lang = document.createElement('script');
    lang.id = id;
    lang.src = 'https://cdn.statsfc.com/js/lang/' + l + '.js';

    flang.parentNode.insertBefore(lang, flang);
  };
}

/**
 * Load widgets dynamically using data-* attributes
 */
$j('div.statsfc-form').each(function () {
  var key = $j(this).attr('data-key'),
    form = new StatsFC_Form(key),
    data = $j(this).data();

  for (var i in data) {
    form[i] = data[i];
  }

  form.display($j(this));
});
