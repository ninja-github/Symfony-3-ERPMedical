            $(document).ready(function ($) {
                // delegate calls to data-toggle="lightbox"
                $(document).on('click', '[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        onShown: function() {
                            if (window.console) {
                                return console.log('Checking our the events huh?');
                            }
                        },
						onNavigate: function(direction, itemIndex) {
                            if (window.console) {
                                return console.log('Navigating '+direction+'. Current item: '+itemIndex);
                            }
						}
                    });
                });

                //Programmatically call
                $('#open-image').click(function (e) {
                    e.preventDefault();
                    $(this).ekkoLightbox();
                });
                $('#open-youtube').click(function (e) {
                    e.preventDefault();
                    $(this).ekkoLightbox();
                });

				// navigateTo
                $(document).on('click', '[data-toggle="lightbox"][data-gallery="navigateTo"]', function(event) {
                    event.preventDefault();

                    return $(this).ekkoLightbox({
                        onShown: function() {

							this.modal().on('click', '.modal-footer a', function(e) {

								e.preventDefault();
								this.navigateTo(2);

                            }.bind(this));

                        }
                    });
                });


                /**
                 * Documentation specific - ignore this
                 */
                anchors.options.placement = 'left';
                anchors.add('h3');
                $('code[data-code]').each(function() {

                    var $code = $(this),
                        $pair = $('div[data-code="'+$code.data('code')+'"]');

                    $code.hide();
                    var text = $code.text($pair.html()).html().trim().split("\n");
                    var indentLength = text[text.length - 1].match(/^\s+/)
                    indentLength = indentLength ? indentLength[0].length : 24;
                    var indent = '';
                    for(var i = 0; i < indentLength; i++)
                        indent += ' ';
                    if($code.data('trim') == 'all') {
                        for (var i = 0; i < text.length; i++)
                            text[i] = text[i].trim();
                    } else  {
                        for (var i = 0; i < text.length; i++)
                            text[i] = text[i].replace(indent, '    ').replace('    ', '');
                    }
                    text = text.join("\n");
                    $code.html(text).show();

                });
            });