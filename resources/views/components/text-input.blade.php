@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-md border-gray-300 bg-[#D9D9D9] text-black dark:bg-[#000000] dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500']) }}>
