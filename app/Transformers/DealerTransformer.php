<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\Dealer;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class DealerTransformer extends TransformerAbstract
{
    /**
     * @param \App\Dealer $dealer
     * @return array
     */
    public function transform(Dealer $dealer): array
    {
        $editLink = Link::edit(route('dealers.edit', $dealer->id));
        $deleteLink = Link::delete(route('dealers.destroy', $dealer->id), message:'Are you sure to delete this dealer?');

        return [
            'id' => (int) $dealer->id,
            'name' => (string) $dealer->name,
            'mobile' => (int) $dealer->mobile,
            'address' => (string) $dealer->address,
            'status' => (string) Str::ucfirst($dealer->status),
            'action' => Link::generate($editLink, $deleteLink),
        ];
    }
}
