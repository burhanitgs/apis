<?php		
		
		//namespace App;
		namespace App\Models;
        use Illuminate\Database\Eloquent\Model;
        class Onboard extends Model
        {
			protected $table = 'onboard';

            /**
             * The attributes that are mass assignable.
             *
             * @var array
             */
            protected $fillable = [
                'birth_sex', 'employment_status','occupation','education_level',
				'total_children','pregnant','gestation','expected_babies','user_id'
            ];
        }