<?php

/**
 * Adds Joshua_Project_Country_Widget widget.
 */
class Joshua_Project_Country_Widget extends WP_Widget {

	/**
	 * Make some vars
	 */
	private $allowed_types = NULL;
	private $jp_data	   = NULL;
	private $old_vals      = array();


	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		parent::__construct(
			'joshua-project-country-info-widget', // Base ID
			__( 'Joshua Project, Nation Info', 'joshua-project-country-info-widget' ), // Name
			array( 'description' => __( 'Renders nation data from The Joshua Project.', 'joshua-project-country-info-widget' ), )
		);

		add_action( 'wp_head', array( $this, 'widget_css' ) );

		$this->jp_data = new T1K_JoshuaProjectData;

		$this->allowed_types = array(
			'random_freebie' => 'One Random Freebie',
			'latest_freebie' => 'Latest Freebie',
		);

	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args	  Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		$title	= '';
		$output = '';
		$country_code = $instance['t1k_jp_option'];

		$this->jp_data->set_country( esc_attr( $country_code ) );

		$country_data = $this->jp_data->get_data();
	
		$percent_unreached = round( ( $country_data->cntPeoplesLR / $country_data->cntPeoples ) * 100, 2 );

		// see if there's data
		if ( $country_data != '' ) {

			$title = 'About ' . $country_data->name;

			$output .= '<div class="jp_country_data">' . "\n\n";

			// see if we have an image
			if ( file_exists( plugin_dir_path( __FILE__ ) . '../images/' . strtolower( $country_code ) . '-flag.gif' ) && $instance['t1k_jp_flag'] == 1 ) {
				$output .= '<img src="' . esc_url( plugins_url( 'images/' . strtolower( $country_code ) . '-flag.gif', dirname( __FILE__ ) ) ) . '" />' . "\n";
			}
			$output .= '<ul>' . "\n";

			if ( is_numeric( $country_data->population->__toString() ) && $instance['t1k_jp_population'] == 1 ) {
				$output .= '<li>' . __( 'Population', 'jp-nation-info' ) . ': ' . number_format( $country_data->population->__toString() ) . '</li>' . "\n";
			}

			if ( is_numeric( $percent_unreached ) && $instance['t1k_jp_unreached'] == 1 ) {
				$output .= '<li>' . __( 'Unreached', 'jp-nation-info' ) . ': ' . $percent_unreached . '%</li>' . "\n";
			}

			if ( is_numeric( $country_data->cntPeoples->__toString() ) && $instance['t1k_jp_people_groups'] == 1 ) {
				$output .= '<li>' . __( 'People Groups', 'jp-nation-info' ) . ': ' . number_format( $country_data->cntPeoples->__toString() ) . '</li>' . "\n";
			}

			if ( ( is_numeric( $country_data->cntPeoplesLR->__toString() ) ) && $instance['t1k_jp_unreached_groups'] == 1 ) {
				$output .= '<li>' . __( 'Unreached Groups', 'jp-nation-info' ) . ': ' . number_format( $country_data->cntPeoplesLR->__toString() ) . '</li>' . "\n";
			}

			if ( $instance['t1k_jp_primary_language'] == 1 ) {
				$output .= '<li>' . __( 'Primary Language', 'jp-nation-info' ) . ': ' . $country_data->primaryLanguage . '</li>' . "\n";
			}

			if ( $instance['t1k_jp_primary_religion'] == 1 ) {
				$output .= '<li>' . __( 'Primary Religion', 'jp-nation-info' ) . ': ' . $country_data->primaryReligion . '</li>' . "\n";
			}

			if ( $instance['t1k_jp_evangelical'] == 1 ) {
				$output .= '<li>' . __( 'Evangelical', 'jp-nation-info' ) . ': ' . $country_data->percentEvangelical . '%</li>' . "\n";
			}

			$output .= '</ul>' . "\n";

			$output .= '<h5><a href="https://mnnonline.org/archives/country/' . $country_data->name . '">Missions News About ' . $country_data->name . '</a></h5>' . "\n";

			$output .= '<h5><a href="http://www.joshuaproject.net/countries/' . $country_code . '" target="_new">Info About ' . $country_data->name . '</a></h5>' . "\n";

			$output .= '<h6>Data from the <a href="http://www.joshuaproject.net/" target="_new">Joshua Project</a></h6>' . "\n";
			
			$output .= '</div>' . "\n\n";
		}

		echo wp_kses_post( $args['before_widget'] );
		if ( ! empty( $title ) )
		echo wp_kses_post( $args['before_title'] ) . esc_html( $title ) . wp_kses_post( $args['after_title'] );
		echo wp_kses_post( $output );
		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Front-end css for widget.
	 */
	public function widget_css() {

		$output = '';

		// make sure we actually have a widget
		if ( is_active_widget( false, false, $this->id_base, true ) ) {

			// don't show the styles if the filter has them off
			if ( ! apply_filters( 't1k-jp-country-data-styles', true ) ) { return; }

			$output .= '<style type="text/css">' . "\n";

				$output .= '.widget_joshua-project-country-info-widget img { max-width: 100%; }' . "\n";
				$output .= '.widget_joshua-project-country-info-widget ul { list-style-type: none; border-bottom: 1px solid #ccc;}' . "\n";

			$output .= '</style>' . "\n";
		}

		print $output;

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$this->old_vals[ 't1k_jp_flag' ]             = isset( $instance[ 't1k_jp_flag' ] ) ? absint( $instance[ 't1k_jp_flag' ] ) : '';
		$this->old_vals[ 't1k_jp_population' ]       = isset( $instance[ 't1k_jp_population' ] ) ? absint( $instance[ 't1k_jp_population' ] ) : '';
		$this->old_vals[ 't1k_jp_unreached' ]        = isset( $instance[ 't1k_jp_unreached' ] ) ? absint( $instance[ 't1k_jp_unreached' ] ) : '';
		$this->old_vals[ 't1k_jp_people_groups' ]    = isset( $instance[ 't1k_jp_people_groups' ] ) ? absint( $instance[ 't1k_jp_people_groups' ] ) : '';
		$this->old_vals[ 't1k_jp_unreached_groups' ] = isset( $instance[ 't1k_jp_unreached_groups' ] ) ? absint( $instance[ 't1k_jp_unreached_groups' ] ) : '';
		$this->old_vals[ 't1k_jp_primary_language' ] = isset( $instance[ 't1k_jp_primary_language' ] ) ? absint( $instance[ 't1k_jp_primary_language' ] ) : '';
		$this->old_vals[ 't1k_jp_primary_religion' ] = isset( $instance[ 't1k_jp_primary_religion' ] ) ? absint( $instance[ 't1k_jp_primary_religion' ] ) : '';
		$this->old_vals[ 't1k_jp_evangelical' ]      = isset( $instance[ 't1k_jp_evangelical' ] ) ? absint( $instance[ 't1k_jp_evangelical' ] ) : '';

		?>


		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 't1k_jp_option' ) ); ?>"><?php _e( 'Choose Country', 'jp-nation-info' ); ?></label> 
			<select name="<?php echo esc_attr( $this->get_field_name( 't1k_jp_option' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 't1k_jp_option' ) ); ?>" class="widefat">
				<?php
					foreach ( $this->jp_data->get_country_codes() as $country_code => $country_name ) {
						echo '<option value="' . esc_attr( $country_code ) . '" id="jp_' . esc_attr( $country_code ) . '"' . esc_html( selected( $instance['t1k_jp_option'], $country_code ) ) .  '>' . esc_html( $country_name ) .  '</option>';
					}
				?>
			</select>
		</p>

		<h4><?php _e( 'Show', 'jp-nation-info' ); ?>:</h4>
		
		<ul>

		<li>
		<input id="<?php echo esc_attr( $this->get_field_id( 't1k_jp_flag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 't1k_jp_flag' ) ); ?>" type="checkbox" value="1" <?php echo esc_attr( checked( '1', $this->old_vals[ 't1k_jp_flag' ], false ) ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 't1k_jp_flag' ) ); ?>"> <?php _e( 'Flag', 'jp-nation-info' ); ?></label>
		</li>

		<li>
		<input id="<?php echo esc_attr( $this->get_field_id( 't1k_jp_population' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 't1k_jp_population' ) ); ?>" type="checkbox" value="1" <?php echo esc_attr( checked( '1', $this->old_vals[ 't1k_jp_population' ], false ) ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 't1k_jp_population' ) ); ?>"> <?php _e( 'Population', 'jp-nation-info' ); ?></label>
		</li>

		<li>
		<input id="<?php echo esc_attr( $this->get_field_id( 't1k_jp_unreached' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 't1k_jp_unreached' ) ); ?>" type="checkbox" value="1" <?php echo esc_attr( checked( '1', $this->old_vals[ 't1k_jp_unreached' ], false ) ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 't1k_jp_unreached' ) ); ?>"> <?php _e( 'Unreached Percentage', 'jp-nation-info' ); ?></label>
		</li>

		<li>
		<input id="<?php echo esc_attr( $this->get_field_id( 't1k_jp_people_groups' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 't1k_jp_people_groups' ) ); ?>" type="checkbox" value="1" <?php echo esc_attr( checked( '1', $this->old_vals[ 't1k_jp_people_groups' ], false ) ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 't1k_jp_people_groups' ) ); ?>"> <?php _e( 'People Groups', 'jp-nation-info' ); ?></label>
		</li>

		<li>
		<input id="<?php echo esc_attr( $this->get_field_id( 't1k_jp_unreached_groups' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 't1k_jp_unreached_groups' ) ); ?>" type="checkbox" value="1" <?php echo esc_attr( checked( '1', $this->old_vals[ 't1k_jp_unreached_groups' ], false ) ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 't1k_jp_unreached_groups' ) ); ?>"> <?php _e( 'Unreached People Groups', 'jp-nation-info' ); ?></label>
		</li>

		<li>
		<input id="<?php echo esc_attr( $this->get_field_id( 't1k_jp_primary_language' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 't1k_jp_primary_language' ) ); ?>" type="checkbox" value="1" <?php echo esc_attr( checked( '1', $this->old_vals[ 't1k_jp_primary_language' ], false ) ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 't1k_jp_primary_language' ) ); ?>"> <?php _e( 'Primary Language', 'jp-nation-info' ); ?></label>
		</li>

		<li>
		<input id="<?php echo esc_attr( $this->get_field_id( 't1k_jp_primary_religion' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 't1k_jp_primary_religion' ) ); ?>" type="checkbox" value="1" <?php echo esc_attr( checked( '1', $this->old_vals[ 't1k_jp_primary_religion' ], false ) ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 't1k_jp_primary_religion' ) ); ?>"> <?php _e( 'Primary Religion', 'jp-nation-info' ); ?></label>
		</li>

		<li>
		<input id="<?php echo esc_attr( $this->get_field_id( 't1k_jp_evangelical' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 't1k_jp_evangelical' ) ); ?>" type="checkbox" value="1" <?php echo esc_attr( checked( '1', $this->old_vals[ 't1k_jp_evangelical' ], false ) ); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 't1k_jp_evangelical' ) ); ?>"> <?php _e( 'Percent Evangelical', 'jp-nation-info' ); ?></label>
		</li>
		
		</ul>


		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['t1k_jp_option']           = wp_kses_post( $new_instance['t1k_jp_option'] );
		$instance['t1k_jp_flag']             = ( ! empty( $new_instance['t1k_jp_flag'] ) ) ? strip_tags( $new_instance[ 't1k_jp_flag' ] ) : '';
		$instance['t1k_jp_population']       = ( ! empty( $new_instance['t1k_jp_population'] ) ) ? strip_tags( $new_instance[ 't1k_jp_population' ] ) : '';
		$instance['t1k_jp_unreached']        = ( ! empty( $new_instance['t1k_jp_unreached'] ) ) ? strip_tags( $new_instance[ 't1k_jp_unreached' ] ) : '';
		$instance['t1k_jp_people_groups']    = ( ! empty( $new_instance['t1k_jp_people_groups'] ) ) ? strip_tags( $new_instance[ 't1k_jp_people_groups' ] ) : '';
		$instance['t1k_jp_unreached_groups'] = ( ! empty( $new_instance['t1k_jp_unreached_groups'] ) ) ? strip_tags( $new_instance[ 't1k_jp_unreached_groups' ] ) : '';
		$instance['t1k_jp_primary_language'] = ( ! empty( $new_instance['t1k_jp_primary_language'] ) ) ? strip_tags( $new_instance[ 't1k_jp_primary_language' ] ) : '';
		$instance['t1k_jp_primary_religion'] = ( ! empty( $new_instance['t1k_jp_primary_religion'] ) ) ? strip_tags( $new_instance[ 't1k_jp_primary_religion' ] ) : '';
		$instance['t1k_jp_evangelical']      = ( ! empty( $new_instance['t1k_jp_evangelical'] ) ) ? strip_tags( $new_instance[ 't1k_jp_evangelical' ] ) : '';

		return $instance;
	}

} // class Joshua_Project_Country_Widget
