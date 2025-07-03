<div class="w-full bg-white p-9 rounded shadow mb-6 mt-[24px]">
    <label class="block font-semibold text-base text-gray-700 mb-4">
        Pada saat lulus, pada tingkat mana kompetensi di bawah ini Anda kuasai?
        <span class="text-red-600">*</span>
    </label>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-800 border border-gray-300 table-auto">
            <thead class="bg-gray-100 text-center">
                <tr>
                    <th class="border px-4 py-2 text-left">Kompetensi</th>
                    @foreach ($kompetensiOptions as $opt)
                        <th class="border px-4 py-2">{{ $opt }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($kompetensiFields as $field => $label)
                    <tr class="even:bg-gray-50">
                        <td class="border px-4 py-2">{{ $label }}</td>
                        @foreach ($kompetensiOptions as $opt)
                            <td class="border px-4 py-2 text-center">
                                <input type="radio"
                                    name="kompetensi_lulus[{{ $field }}]"
                                    value="{{ $opt }}"
                                    required
                                    class="form-radio text-orange-600 focus:ring focus:ring-orange-300">
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
