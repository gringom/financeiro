<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
	use \Venturecraft\Revisionable\RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 50;
    protected $revisionNullString = 'não havia nada preenchido';
	protected $revisionUnknownString = 'desconhecido'; 

	protected $revisionFormattedFields = array(
	    'payment_date' => 'datetime:d/m/Y',
	    'paid_date' => 'datetime:d/m/Y',
	);

	protected $revisionFormattedFieldNames = array(
	    'type' => 'Tipo',
	    'account_id' => 'Conta',
	    'category_id' => 'Categoria',
	    'person_id' => 'Cliente/Fornecedor',
	    'project_id' => 'Projeto',
	    'value' => 'Valor',
	    'payment_date' => 'Data do Vencimento',
	    'paid_date' => 'Data do Pagamento',
	    'description' => 'Descrição'
	);

    protected $fillable = ['type', 'account_id', 'category_id', 'person_id', 'project_id', 'value', 'payment_date', 'paid_date', 'description'];

	public static function boot()
    {
        parent::boot();
    }

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function person()
	{
		return $this->belongsTo(Person::class);
	}

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

	public function by($id)
	{
		$this->user_id = $id;
	}
}
